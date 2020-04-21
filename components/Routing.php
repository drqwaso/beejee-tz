<?php

namespace components;

use components\exceptions\NotFoundException;
use components\interfaces\ContainerInterface;

class Routing
{
    /** @var array */
    private $routes = [];

    /** @var */
    private $defaultRoute;

    /** @var ContainerInterface */
    private $container;

    /**
     * Routing constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $routes
     */
    public function setRoutes(array $routes)
    {
        foreach ($routes as $url => $routeData) {
            list($className, $actionName) = $routeData;

            $this->addRoute(
                $this->createRoute($url, $className, $actionName)
            );
        }
    }

    /**
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[$route->getUrl()] = $route;
    }

    /**
     * @param string $defaultRoute
     */
    public function setDefaultRoute(string $defaultRoute)
    {
        $this->defaultRoute = $defaultRoute;
    }

    /**
     * @param string $url
     * @return Route|null
     */
    public function getRoute(string $url): ?Route
    {
        return $this->routes[$url] ?? null;
    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed
     * @throws NotFoundException
     */
    public function followRoute(string $url, array $params = [])
    {
        if ($url === '/') {
            return $this->followDefaultRoute($params);
        }

        $route = $this->getRoute($url);

        if (!$route) {
            throw new NotFoundException('Страница не найдена');
        }

        return $this->action(
            $route->getControllerClass(),
            $route->getActionName(),
            $params
        );
    }

    /**
     * @param array $params
     * @return mixed
     * @throws NotFoundException
     */
    public function followDefaultRoute(array $params = [])
    {
        if (!$this->defaultRoute) {
            throw new \RuntimeException('Default route not set');
        }

        return $this->followRoute($this->defaultRoute, $params);
    }

    /**
     * @param string $className
     * @param string $actionName
     * @param array $params
     * @return mixed
     */
    public function action(string $className, string $actionName, array $params = [])
    {
        try {
            $reflectionMethod = new \ReflectionMethod($className, $actionName);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException("Действие {$actionName} не обнаружено в контроллере {$className}");
        }

        if (!$reflectionMethod->isPublic() || $reflectionMethod->isStatic()) {
            throw new \RuntimeException('В качеcтве действия контроллера
                может быть использован публичный нестатический метод');
        }

        $actionParams = [];
        if ($reflectionParams = $reflectionMethod->getParameters()) {
            foreach ($reflectionParams as $reflectionParam) {
                $paramName = $reflectionParam->getName();
                $actionParams[] = $params[$paramName] ?? null;
            }
        }

        return $reflectionMethod->invokeArgs($this->container->get($className), $actionParams);
    }

    /**
     * @param string $url
     * @param string $className
     * @param string $actionName
     * @return Route
     */
    public function createRoute(string $url, string $className, string $actionName)
    {
        if (!method_exists($className, $actionName)) {
            throw new \LogicException("Действие {$actionName} не обнаружено в контроллере {$className}");
        }

        $route = new Route(
            $url,
            $className,
            $actionName
        );

        return $route;
    }
}
