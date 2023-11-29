<?php


namespace App\Repositories;

use App\Collections\ArticleCollection;
use App\Models\Article;

class CombinedArticleRepository implements ArticleRepository
{
    private MysqlArticleRepository $mysqlArticleRepository;
    private NewsApiArticleRepository $newsApiArticleRepository;
    public function __construct(
        MysqlArticleRepository $mysqlArticleRepository,
        NewsApiArticleRepository $newsApiArticleRepository
    )
    {
        $this->mysqlArticleRepository = $mysqlArticleRepository;
        $this->newsApiArticleRepository = $newsApiArticleRepository;
    }

    public function getAll(): ArticleCollection
    {
        $apiArticles = $this->newsApiArticleRepository->getAll();
        $articles = $this->mysqlArticleRepository->getAll();

        $articles->merge($apiArticles);

        return $articles;
    }

    public function getById(int $id): ?Article
    {
        return $this->mysqlArticleRepository->getById($id);
    }

    public function save(Article $article): void
    {
        $this->mysqlArticleRepository->save($article);
    }

    public function delete(Article $article): void
    {
        $this->mysqlArticleRepository->delete($article);
    }
}