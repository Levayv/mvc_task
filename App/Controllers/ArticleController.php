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
        // TODO: Implement index() method.
        $article = new Model();
        $article->getList();
        //$article->getSingle();
        ViewHandler::doSomething('home', ['articles' => $article->getList()]);
        return 'mock_data'; //todo research further
    }
}
