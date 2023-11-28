<?php

namespace App\Services\Article;


use App\Models\Article;
use App\Repositories\ArticleRepository;


class ShowArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }


    public function execute(int $id): Article
    {

        return $this->articleRepository->getById($id);
    }

}
