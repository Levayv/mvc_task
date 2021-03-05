<?php

namespace Core\Views\ViewHandler;

class ViewHandler
{
    // todo
    //  make composite view Object in Controller ?

    private static $baseDir = '../views/';
    // todo
    //  move to config ?
    //  fix path's inconsistency !

    public static function doSomething($name, $params = [])
    {
        // todo give params to views/subviews etc
        require self::$baseDir . $name . '.php';
    }
}
