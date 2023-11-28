<?php

namespace App\Services\Article;

use App\Repositories\ArticleRepository;


class DeleteArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }


    public function execute(int $id): void
    {
        $article = $this->articleRepository->getById($id);

        $this->articleRepository->delete($article);
    }

}