<?php
/**
 * todo add desc
 */

use \Core\Routes\RouteHandler;

RouteHandler::add('get', '/article', 'ArticleController', 'index', 'article-index');
RouteHandler::add('get', '/article/1', 'ArticleController', 'show', 'article-show');
RouteHandler::add('get', '/article/create', 'ArticleController', 'create', 'article-create');
RouteHandler::add('post', '/article', 'ArticleController', 'store', 'article-store');
