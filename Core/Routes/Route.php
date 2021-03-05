<?php

namespace Core\Routes\Route;

class Route {

    public string $method;
    public string $url;
    public string $controller;
    public string $action;
    public string $name;

    /**
     * Route constructor.
     * @param $method
     * @param $url
     * @param $controller
     * @param $action
     * @param $name
     */
    public function __construct($method , $url , $controller , $action , $name)
    {
        $this->method = $method;
        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->name = $name;
    }
}
