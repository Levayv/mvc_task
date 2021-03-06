<?php

namespace Core;

use Core\Exceptions\BasicException;
use Core\Exceptions\FatalException;
use Core\Routes\RouteHandler;
use Core\Views\ViewHandler;

class Kernel
{

    // todo
    // middleware ?
    // add Request object
    // add config ?

    public function __construct()
    {
    }

    public function start()
    {
        // Register user routes
        require '../App/Routes/routes.php';

        try {
            RouteHandler::handleRequest();
        }
        catch (BasicException $exception){
            $code = $exception->getCode();
            if ($code == 404){
                ViewHandler::doSomething();
                return;
            }
            if ($code == 500){
                //todo add debug mode
                ViewHandler::doSomething($code , $exception->getMessage());
                return;
            }
            throw new FatalException($exception);
        }
    }
}
