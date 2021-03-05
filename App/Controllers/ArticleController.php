<?php

namespace App\Controllers\ArticleController;

use Core\Controllers\Controller\Controller;
use Core\Models\Model\Model;

class ArticleController extends Controller
{
    public function __construct()
    {

    }

    function index()
    {
        // TODO: Implement index() method.
        $article = new Model();
        return 'mock_data';
    }
}
