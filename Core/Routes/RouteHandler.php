<?php

namespace Core\Routes;

use App\Controllers\ArticleController;
use Core\Routes\Route;
use Core\Views\ViewHandler;

final class RouteHandler
{
    // REST cheat sheet ...
    //
    // action get/post desc
    //
    // index get list of all resources
    // show get show single resource
    // create get show resource creation form
    // store post save newly created resource
    // edit get shwo resource edit form
    // update post save existing resource changes
    // delete post delete resource

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

    private function getRequestUrlPath()
    {
        $currentURI = (isset($_SERVER['REQUEST_URI'])) ? ($_SERVER['REQUEST_URI']) : '/article';
        //$currentURI = explode('/', $currentURI);
        // todo change this solution , it is for single resource handling ONLY
        return $currentURI;
    }

    public static function doSomething()
    {
        // todo move route registration from core to app

        self::add('get', '/article', 'ArticleController', 'index', 'article-index');
        self::add('get', '/article/1', 'ArticleController', 'show', 'article-show');

        self::add('get', '/article/create', 'ArticleController', 'create', 'article-create');
        self::add('post', '/article', 'ArticleController', 'store', 'article-store');

        // todo end

        //todo create 'request' object
//        $request = [
//            'method' => 'get',
//            'url' => '/home',
//            'controller' => 'ArticleController',
//            'action' => 'index',
//            'route_name' => 'show-article',
//        ];

        $routePath = self::getRequestUrlPath();
        $routeBagActive = null;


        if (!isset($_SERVER['REQUEST_METHOD'])) $_SERVER['REQUEST_METHOD'] = 'GET';
        echo 'request method is ' . $_SERVER['REQUEST_METHOD'] . PHP_EOL;


        if (!$_SERVER['REQUEST_METHOD'] == 'GET' || !$_SERVER['REQUEST_METHOD'] == 'POST') {
            ViewHandler::doSomething('500');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $routeBagActive = self::$routeBagGET;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $routeBagActive = self::$routeBagPOST;
        }

        // todo optimise ... look for array function complexities
        if (in_array($routePath, array_column($routeBagActive, 'url'))) {
            $key = null;
            echo (isset($key) ? 'true' : 'false');
            $key = array_search($routePath, array_column($routeBagActive, 'url'));
            // todo research if this solution makes sense ? Is it even slightly faster then directly searching ?

            if (!isset($key)) {
                ViewHandler::doSomething('500' , 'route not found , key = '.$key);
            }
        }

        echo '<pre>' . '$routePath = ' . print_r($routePath, 1) . '</pre>';
        echo '<pre>' . '$routeBag = ' . print_r(array_column($routeBagActive, 'url'), 1) . '</pre>';
        echo '<pre>' . 'foundByKey controller = ' . print_r($routeBagActive[$key]->controller, 1) . '</pre>';
        echo '<pre>' . 'foundByKey action = ' . print_r($routeBagActive[$key]->action, 1) . '</pre>';

//         $controllerInstance = new ArticleController;
//         $controllerInstance->index();

        $controllerClassName = 'App\Controllers\\'.$routeBagActive[$key]->controller;
        $controllerActionName = $routeBagActive[$key]->action;

        // todo fix namespaces ... why its double nested ???????????????
//        use App\Controllers\ArticleController\ArticleController;

        $controllerInstance = new $controllerClassName;
        $controllerInstance->$controllerActionName();

//        switch ($routePath) {
//            // todo
//            //  determine controller name and pass to CORE ?
//            //  parse request parameters to
//            //  id ?
//
//            case '/home' :
//                $controller = new ArticleController();
//                $controller->index();
//                break;
//            default:
//                ViewHandler::doSomething('404');
//        }

    }
}
