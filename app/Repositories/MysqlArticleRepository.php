<?php

namespace App\Repositories;


use App\Collections\ArticleCollection;
use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MysqlArticleRepository implements ArticleRepository
{
    protected Connection $database;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => 'articles_webpage',
            'user' => 'root',
            'password' => '123',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $this->database = DriverManager::getConnection($connectionParams);
    }

    public function getAll(): ArticleCollection
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollection();

        foreach ($articles as $data) {
            $articlesCollection->add(
                $this->buildModel($data)
            );
        }
        return $articlesCollection;
    }

    public function getById(int $id): ?Article
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        if(empty($data)){
            return null;
        }

        return $this->buildModel($data);
    }

    public function save(Article $article): void
    {
        if ($article->getId()) {
            $this->update($article);
            return;
        }
        $this->insert($article);
    }

    public function delete(Article $article): void
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', $article->getId())
            ->executeQuery();
    }

    private function update(Article $article): void
    {
        $this->database->createQueryBuilder()
            ->update('articles')
            ->set('title', ':title')
            ->set('description', ':description')
            ->set('picture', ':picture')
            ->where('id = :id')
            ->setParameters([
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'updated_at' => $article->getUpdatedAt()
            ])->executeQuery();
    }

    private function insert(Article $article): void
    {
        $this->database->createQueryBuilder()
            ->insert('articles')
            ->values(
                [
                    'title' => ':title',
                    'description' => ':description',
                    'picture' => ':picture',
                    'created_at' => ':created_at',
                ]
            )->setParameters([
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'created_at' => $article->getCreatedAt()
            ])->executeQuery();

    }

    private function buildModel(array $data): Article
    {
        return new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            null,
            $data['created_at'],
            (int)$data['id'],
            $data['updated_at']
        );

    }
}