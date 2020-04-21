<?php

namespace components;

use components\db\MysqlConnection;
use components\interfaces\ContainerInterface;

class Container implements ContainerInterface
{
    /** @var array */
    protected $definitions = [];

    /** @var array */
    protected $shared = [];

    public function __construct(Config $config)
    {
        $this->shared[Config::class] = $config;
        $this->init($config);
    }

    /**
     * @param Config $config
     */
    protected function init(Config $config)
    {
        $this->definitions = [
            MysqlConnection::class => [
                'shared' => true,
                'arguments' => [
                    $this,
                ],
            ],
            App::class => [
                'shared' => true,
                'arguments' => [
                    $this,
                ],
            ],
            View::class => [
                'calls' => [
                    'setTemplatesDir' => [$config->getRequired('templatesDir')],
                    'setLayout' => [$config->getRequired('layout')],
                ],
            ],
            Routing::class => [
                'shared' => true,
                'arguments' => [
                    $this,
                ],
                'calls' => [
                    'setRoutes' => [$config->getRequired('routes')],
                    'setDefaultRoute' => [$config->getRequired('defaultRoute')],
                ],
            ],
            Controller::class => [
                'arguments' => [
                    View::class,
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if (isset($this->shared[$name])) {
            return $this->shared[$name];
        }

        if (isset($this->definitions[$name])) {
            $definition = $this->definitions[$name];
            $instance = $this->createFromDefinition($name, $definition);

            if (isset($definition['shared'])) {
                $this->shared[$name] = $instance;
            }

            return $instance;
        }

        if (class_exists($name)) {
            $this->shared[$name] = $this->createFromClass($name);
            return $this->shared[$name];
        }

        throw new \LogicException("Зависимость $name не найдена");
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return isset($this->shared[$name]) || isset($this->definitions[$name]);
    }

    /**
     * @param string $name
     * @param array $definition
     * @return object
     */
    private function createFromDefinition(string $name, array $definition)
    {
        if (!isset($definition['class']) && !class_exists($name)) {
            throw new \LogicException("Не указан класс зависимости $name");
        }

        return $this->createFromClass(
            $definition['class'] ?? $name,
            $definition['arguments'] ?? [],
            $definition['calls'] ?? null
        );
    }

    /**
     * @param string $className
     * @param array $arguments
     * @param array|null $calls
     * @return object
     */
    private function createFromClass(
        string $className,
        array $arguments = [],
        array $calls = null
    ) {
        try {
            $reflection = new \ReflectionClass($className);
            $instance = $reflection->newInstanceArgs($this->resolveArguments($arguments));

            if ($calls) {
                foreach ($calls as $methodName => $methodArguments) {
                    call_user_func_array(
                        [$instance, $methodName],
                        $this->resolveArguments($methodArguments)
                    );
                }
            }
        } catch (\Throwable $e) {
            throw new \RuntimeException("Ошибка при создании объкта $className", $e->getCode(), $e);
        }

        return $instance;
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function resolveArguments(array $arguments): array
    {
        $resolvedArguments = [];

        if ($arguments) {
            foreach ($arguments as $argument) {
                $resolvedArguments[] = is_string($argument) && $this->has($argument)
                    ? $this->get($argument)
                    : $argument;
            }
        }

        return $resolvedArguments;
    }
}
