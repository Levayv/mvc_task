<?php

namespace App\Controllers;

use Core\Controllers\Controller;
use App\Models\Article;
use Core\Views\ViewHandler;

class ArticleController extends Controller
{
    public function __construct()
    {

    }

    function index()
    {
        $article = new Article();
        $article->getList();

        ViewHandler::doSomething('index', ['articles' => $article->getList()]);
        return 'mock_data'; //todo research further
    }

    function show()
    {
        $article = new Article();
        ViewHandler::doSomething('show', ['article' => $article->getSingle()]);
        return 'mock_data'; //todo research further
    }
}
