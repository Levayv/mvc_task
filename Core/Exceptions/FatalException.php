<?php


namespace Core\Exceptions;

use Core\Exceptions\BasicException;

class FatalException extends BasicException
{
    /**
     * @param \Core\Exceptions\BasicException $exception
     */
    public function __construct(BasicException $exception)
    {
        parent::__construct($exception->message, $exception->code);
    }
}