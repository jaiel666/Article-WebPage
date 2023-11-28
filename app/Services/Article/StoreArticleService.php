<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class StoreArticleService
{
   private ArticleRepository $articleRepository;

    public function __construct()
    {
       $this->articleRepository = new ArticleRepository();
    }


    public function execute(string $title, string $description, string $picture): void
    {
        $article = new Article(
            $title,
            $description,
            $picture,
        );

        $this->articleRepository->save($article);
    }

}