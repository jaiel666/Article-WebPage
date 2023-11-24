<?php

namespace App\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
abstract class BaseController
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
}
