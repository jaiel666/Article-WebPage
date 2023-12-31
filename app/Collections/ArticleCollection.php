<?php


namespace App\Collections;


use App\Models\Article;

class ArticleCollection
{
    private array $articles = [];
    public function __construct(array $articles = [])
    {
        foreach ($articles as $article)
        {
            if (! $article instanceof Article)
            {
                continue;
            }
            $this->articles = $articles;
        }
    }

    public function add(Article $article):void
    {
        $this->articles[] = $article;
    }
    public function getAll(): array
    {
        return $this->articles;
    }

    public function merge(ArticleCollection $collection): void
    {
        $this->articles = array_merge($this->articles, $collection->getAll());
    }

}