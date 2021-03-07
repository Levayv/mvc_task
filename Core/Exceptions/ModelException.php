<?php


namespace Core\Exceptions;

use Core\Exceptions\BasicException;
use Core\Models\DBConnection;

class ModelException extends BasicException
{
    /**
     * @param string $message
//     * @param DBConnection $connection
//     * @param string $blameSql
     */
    public function __construct($message /*, DBConnection $connection, string $sql*/)
    {
        //todo implement data parsing
        parent::__construct($message);
    }
}