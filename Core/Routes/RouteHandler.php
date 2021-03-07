<?php

namespace Core\Routes;

use Core\Exceptions\BasicException;
use Core\Exceptions\FatalException;
use Core\Http\Request;

final class RouteHandler
{
    // REST cheat sheet ...
    //
    // action   method  description
    //
    // index    get     list of all resources
    // show     get     show single resource
    // create   get     show resource creation form
    // store    post    save newly created resource
    // edit     get     show resource edit form
    // update   post    save existing resource changes
    // delete   post    delete resource

    private static array $routeBagGET = [];
    private static array $routeBagPOST = [];

    /**
     *  add new route
     * @param string $method
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param string $name
     */
    public static function add($method, $url, $controller, $action, $name = '')
    {
        if ($method == 'GET' || $method == 'get') {
            array_push(self::$routeBagGET, new Route ('get', $url, $controller, $action, $name));
        }
        if ($method == 'POST' || $method == 'post') {
            array_push(self::$routeBagPOST, new Route ('post', $url, $controller, $action, $name));
        }
    }

    /**
     * Find corresponding Controller by incoming request's route
     * @param Request $request
     * @throws BasicException
     */
    public static function handleRequest(Request $request)
    {

        // todo change this solution , it is for single resource handling ONLY
        $routePath = $request->getURL();
        $routeBagActive = null;

        if ($request->method() == 'GET') {
            $routeBagActive = self::$routeBagGET;
        }
        if ($request->method() == 'POST') {
            $routeBagActive = self::$routeBagPOST;
        }

        // todo optimise ... look for array function complexities
        if (in_array($routePath, array_column($routeBagActive, 'url'))) {
            $key = array_search($routePath, array_column($routeBagActive, 'url'));
            // todo research if this solution makes sense ? Is it even slightly faster then directly searching ?
        }
        if (!isset($key)) {
            throw new BasicException('route not found', 500);
        }

        logger('Passing to Controller');
        logger('class = ' . $routeBagActive[$key]->controller);
        logger('action = ' . $routeBagActive[$key]->action);

        // Example
        // $controllerInstance = new ArticleController;
        // $controllerInstance->index();

        $controllerClassName = 'App\Controllers\\' . $routeBagActive[$key]->controller;
        $controllerActionName = $routeBagActive[$key]->action;

        $controllerInstance = new $controllerClassName;
        $controllerInstance->$controllerActionName();

    }

    public static function getRouteByName()
    {
        throw new BasicException('Route::getRouteByName not implemented');
        //todo implement ... move to Route object instead of route handler
    }
}
