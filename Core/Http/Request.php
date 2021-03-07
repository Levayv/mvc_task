<?php

namespace Core\Http;

use Core;
use Core\Exceptions\BasicException;
use DateTime;

class Request
{
    private string $method;
    private string $url;
    private array $params;

    /**
     * @throws BasicException
    */
    public function __construct()
    {
        $this->getCurrentInfo();
    }

    /**
     * Assemble request information from super global
     * @throws BasicException
     */
    private function getCurrentInfo()
    {
        if (!isset($_SERVER['REQUEST_URI']))
            throw new BasicException('missing request path', 500);

        if (!isset($_SERVER['REQUEST_METHOD']))
            throw new BasicException('missing request method', 500);

        if (!$_SERVER['REQUEST_METHOD'] == 'GET' || !$_SERVER['REQUEST_METHOD'] == 'POST') {
            // todo implement redirect ?
            throw new BasicException('unsupported request method (must be GET or POST)', 400);
        }

        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->url = $_SERVER['REQUEST_URI'];
        $this->params = ['1' => '2']; // todo get request query parameters

        logger('--------------------------');
        logger('Handling Request');
        logger('time = ' . ((new DateTime())->setTimestamp($_SERVER['REQUEST_TIME']))->format('U >> Y-m-d H:i:s'));
        logger('method = ' . $this->method);
        logger('url = ' . $this->url);
        logger('params = ' . implode($this->params));
    }

    public function getURL()
    {
        return $this->url;
    }
    public function method()
    {
        return $this->method;
    }
}
