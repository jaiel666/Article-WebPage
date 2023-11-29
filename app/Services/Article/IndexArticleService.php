<?php

namespace App\Services\Article;

use App\Collections\ArticleCollection;
use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;


class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(): ArticleCollection
    {

        return $this->articleRepository->getAll();
    }

}
