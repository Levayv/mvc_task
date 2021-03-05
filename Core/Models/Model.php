<?php

namespace Core\Models;

use ReflectionClass;

class Model
{
    private string $tableName;

    public function __construct()
    {
        $this->tableName = mb_strtolower((new ReflectionClass($this))->getShortName()) . 's';
    }

    // todo accessor mutator using __get __set
    function get()
    {
        return 'mock model data';
    }

    public function getList()
    {
        return [
            1 => 'article one',
            2 => 'article two',
            3 => 'article three',
        ];
    }

    public function getSingle() // add id
    {
        return 'article one';
    }
}
