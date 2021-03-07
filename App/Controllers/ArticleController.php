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
        $articles = Article::getList();

        ViewHandler::doSomething('index', ['articles' => $articles]);
        return 'mock_data'; //todo research further
    }

    function show()
    {
        $article = Article::getSingle(1);

        ViewHandler::doSomething('show', ['article' => $article]);
        return 'mock_data'; //todo research further
    }
}
