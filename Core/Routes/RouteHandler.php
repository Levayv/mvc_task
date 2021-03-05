<?php

namespace Core\Routes\RouteHandler;

use App\Controllers\ArticleController\ArticleController;
use Core\Views\ViewHandler\ViewHandler;

class RouteHandler
{

    public static function doSomething()
    {
        $currentURI = (isset($_SERVER['REQUEST_URI'])) ? ($_SERVER['REQUEST_URI']) : 'home';
        $currentURI = explode('/', $currentURI);
        $routeTemp = $currentURI[1];

        switch ($routeTemp) {
            case 'home' :
                $article = new ArticleController();
                $article->index();
                // todo route >> controller >> view
                ViewHandler::doSomething('home', ['username' => 'JohnDoe12']);
                break;
            default:
                ViewHandler::doSomething('404');
        }

    }
}
