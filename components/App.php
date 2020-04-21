<?php

namespace components;

use components\exceptions\ForbiddenException;
use components\exceptions\NotFoundException;
use components\interfaces\ContainerInterface;

class App
{
    /** @var ContainerInterface */
    private static $container;

    /** @var Request */
    private $request;

    /** @var Routing */
    private $routing;

    /** @var string */
    private $mainController;

    /** @var Config */
    private $config;

    /**
     * App constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        self::$container = $container;

        $this->request = self::getContainer()->get(Request::class);
        $this->routing = self::getContainer()->get(Routing::class);
        $this->config = self::getContainer()->get(Config::class);
        $this->mainController = $this->config->getRequired('mainController');

        if (!class_exists($this->mainController)) {
            throw new \LogicException("Класс {$this->mainController} не найден");
        }
    }

    /**
     * @return ContainerInterface
     */
    public static function getContainer()
    {
        return self::$container;
    }

    public function handleRequest()
    {
        try {
            $this->routing->followRoute($this->request->getRequestUri(), $this->request->paramsGet());
        } catch (ForbiddenException $e) {
            $this->routing->action($this->mainController, 'actionForbidden', [
                'message' => $e->getMessage()
            ]);
        } catch (NotFoundException $e) {
            $this->routing->action($this->mainController, 'actionNotFound', [
                'message' => $e->getMessage()
            ]);
        }
    }
}
