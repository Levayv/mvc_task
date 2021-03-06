<?php

namespace App\Controllers;

use Core\Controllers\Controller;
use Core\Models\Model;
use Core\Views\ViewHandler;

class ArticleController extends Controller
{
    public function __construct()
    {

    }

    function index()
    {
        $article = new Model();
        ViewHandler::doSomething('index', ['articles' => $article->getList()]);
        return 'mock_data'; //todo research further
    }

    function show()
    {
        $article = new Model();
        ViewHandler::doSomething('show', ['article' => $article->getSingle()]);
        return 'mock_data'; //todo research further
    }
}
