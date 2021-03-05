<?php

namespace Core\Routes\RouteHandler;

use App\Controllers\ArticleController\ArticleController;
use Core\Routes\Route\Route;
use Core\Views\ViewHandler\ViewHandler;

final class RouteHandler
{
    private static array $routeBag = [];
    /**
     *  add new route
     * @param string $method
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param string $name
     */
    public static function add($method , $url , $controller , $action , $name = ''){
        array_push(self::$routeBag , new Route ($method , $url , $controller , $action , $name));
    }

    private function getRequestUrlPath() {
        $currentURI = (isset($_SERVER['REQUEST_URI'])) ? ($_SERVER['REQUEST_URI']) : '/home';
        //$currentURI = explode('/', $currentURI);
        // todo change this solution , it is for single resource handling ONLY
        echo $currentURI;
        return $currentURI;
    }

    public static function doSomething()
    {
        // todo move route registration from core to app
        self::add('get','/article','ArticleController','index','show-article');
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



        switch ($routePath) {
            case '/home' :
                // todo determine controller name and pass to CORE ?
                $controller = new ArticleController();
                // todo
                //  parse request parameters to
                //  id ?
                $controller->index();
                break;
            default:
                ViewHandler::doSomething('404');
        }

    }
}
