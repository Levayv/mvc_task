<?php

namespace core\model;

use ReflectionClass;

class Model
{

    public function __construct()
    {
        $this->tableName = mb_strtolower((new ReflectionClass($this))->getShortName()) . 's';
    }

    function get()
    {
        return 'mock model data';
    }

}
