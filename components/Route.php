<?php

namespace components;

class Route
{
    /** @var string */
    private $url;

    /** @var string */
    private $controllerClass;

    /** @var string */
    private $actionName;

    /**
     * Route constructor.
     * @param string $url
     * @param string $controllerClass
     * @param string $actionName
     */
    public function __construct(string $url, string $controllerClass, string $actionName)
    {
        $this->url = $url;
        $this->controllerClass = $controllerClass;
        $this->actionName = $actionName;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }
}
