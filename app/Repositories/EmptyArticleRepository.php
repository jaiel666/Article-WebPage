<?php

namespace App\Repositories;

use App\Collections\ArticleCollection;
use App\Models\Article;
use Carbon\Carbon;

class EmptyArticleRepository implements ArticleRepository
{

    public function getAll(): ArticleCollection
    {
        return new ArticleCollection([
            new Article ('as', 'dsa', 'sada', null, 1),
            new Article ('as', 'dsa', 'sada', null,2),
            new Article ('as', 'dsa', 'sada',null,3)
        ]);
    }

    public function getById(int $id): ?Article
    {
        return null;
    }

    public function save(Article $article): void
    {

    }

    public function delete(Article $article): void
    {

    }
}