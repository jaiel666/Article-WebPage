<?php

namespace App\Repositories;

use App\Collections\ArticleCollection;
use App\Models\Article;
use GuzzleHttp\Client;

class NewsApiArticleRepository implements ArticleRepository
{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
    }

public function getAll(): ArticleCollection
{
    $response = $this->client->get(
        'https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=eb2ece9f0b0e4af2877247e15805c72b'
    );

    $response = json_decode($response->getBody()->getContents(), true);
    $collection = new ArticleCollection();

    foreach ($response['articles'] as $article)
    {
        $collection->add(
            $this->buildModel($article)
        );
    }

    return $collection;
}
public function getById(int $id): ?Article
{
    return null;
}
public function save(Article $article): void{}
public function delete(Article $article): void{}
    private function buildModel(array $data): Article
    {
        return new Article(
            $data['title'] ?? '',
            $data['content'] ?? '',
            $data['urlToImage'] ?? '',
                $data['url'] ?? null,
            $data['publishedAt'] ?? '',
        );

    }
}