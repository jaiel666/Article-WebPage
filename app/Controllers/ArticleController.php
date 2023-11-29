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

class ArticleController
{
    private $indexArticleService;
    private $showArticleService;
    private $storeArticleService;
    private $updateArticleService;
    private $deleteArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        ShowArticleService $showArticleService,
        StoreArticleService $storeArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService
    ) {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->storeArticleService = $storeArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->deleteArticleService = $deleteArticleService;
    }

    public function index()
    {
        $articles = $this->indexArticleService->execute();

        return new ViewResponse('articles/index', [
            'articles' => $articles
        ]);
    }

    public function show(int $id): Response
    {
        $article = $this->showArticleService->execute($id);

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
        $this->storeArticleService->execute($_POST['title'], $_POST['description'], $_POST['picture']);

        return new RedirectResponse('/articles');
    }

    public function edit(int $id): Response
    {
        $article = $this->showArticleService->execute($id);

        return new ViewResponse('articles/edit', [
            'article' => $article
        ]);
    }

    public function update(int $id)
    {
        $this->updateArticleService->execute($id, $_POST['title'], $_POST['description'], $_POST['picture']);

        return new RedirectResponse('/articles/' . $id);
    }

    public function delete(int $id): Response
    {
        $this->deleteArticleService->execute($id);

        return new RedirectResponse('/articles');
    }
}
