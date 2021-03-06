<?php


namespace Core\Exceptions;


use Exception as NativeException;

class BasicException extends NativeException
{

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message , int $code = null)
    {
        parent::__construct($message, $code);
    }
}