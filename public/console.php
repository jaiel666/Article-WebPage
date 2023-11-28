<?php

use App\Services\Article\StoreArticleService;

require '../vendor/autoload.php';

$service = new StoreArticleService();
$service->execute('from console','from console','https://thechive.com/wp-content/uploads/2019/12/person-hilariously-photoshops-animals-onto-random-things-xx-photos-25.jpg?attachment_cache_bust=3136487&quality=85&strip=info&w=400');