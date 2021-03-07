<?php

namespace Core;

use Core\Exceptions\BasicException;
use Core\Exceptions\FatalException;
use Core\Http\Request;
use Core\Routes\RouteHandler;
use Core\Views\ViewHandler;

// I know its ugly
require 'log.php';

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

        $request = new Request();

        try {
            (new RouteHandler)->handleRequest($request);
        } catch (FatalException $exception) {

            // todo refactor error 500 to fatal
            throw new \Exception($exception);

        } catch (BasicException $exception) {

            $code = $exception->getCode();
            // todo refactor this mess
            if ($code == 400) {
                ViewHandler::doSomething(400, $exception->getMessage()); //todo clear temp workaround
                return;
            }
            if ($code == 404) {
                ViewHandler::doSomething($code, $exception->getMessage());
                return;
            }
            if ($code == 500) {
                //todo add debug mode
                ViewHandler::doSomething($code, $exception->getMessage());
                return;
            }
            throw new FatalException($exception);

        }
    }
}
