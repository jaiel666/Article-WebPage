<?php

namespace App\Services\Article;

use App\Collections\ArticleCollection;
use App\Repositories\ArticleRepository;


class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(): ArticleCollection
    {

        return $this->articleRepository->getAll();
    }

}
