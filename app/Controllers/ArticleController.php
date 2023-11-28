<?php

namespace App\Controllers;


use App\RedirectResponse;
use App\Response;
use App\Services\Article\DeleteArticleService;
use App\Services\Article\IndexArticleService;
use App\Services\Article\ShowArticleService;
use App\Services\Article\StoreArticleService;
use App\Services\Article\UpdateArticleService;
use App\ViewResponse;
use Carbon\Carbon;


class ArticleController extends BaseController
{
    public function index()
    {
        $service = new IndexArticleService();
        $articles = $service->execute();

        return new ViewResponse('articles/index', [
            'articles' => $articles
        ]);
    }

    public function show(int $id): Response
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/show', [
            'article' => $article
        ]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): Response
    {
        $service = new StoreArticleService();
        $service->execute($_POST['title'],$_POST['description'],$_POST['picture']);

        return new RedirectResponse('/articles');
    }

    public function edit(int $id): Response
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/edit', [
            'article' => $article
        ]);
    }

    public function update(int $id)
    {
        $service = new UpdateArticleService();
        $service->execute($id,$_POST['title'],$_POST['description'],$_POST['picture']);
        return new RedirectResponse('/articles/' . $id);
    }

    public function delete(int $id): Response
    {
        $service = new DeleteArticleService();
        $service->execute($id);

        return new RedirectResponse('/articles');
    }

}