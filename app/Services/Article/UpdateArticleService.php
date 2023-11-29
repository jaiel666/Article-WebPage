<?php

namespace App\Services\Article;

use App\Repositories\ArticleRepository;
use App\Repositories\MysqlArticleRepository;


class UpdateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(int $id,string $title, string $description, string $picture): void
    {
        $article = $this->articleRepository->getById($id);


        $article->update([
            'title' => $title,
            'description' => $description,
            'picture' => $picture
        ]);

        $this->articleRepository->save($article);

    }

}