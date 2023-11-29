<?php


use App\Controllers\ArticleController;
use App\Repositories\ArticleRepository;
use App\Repositories\CombinedArticleRepository;
use App\Repositories\MysqlArticleRepository;
use App\Repositories\NewsApiArticleRepository;
use GuzzleHttp\Client;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;



require '../vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/../app/Views');
$twig = new Environment($loader);

$builder = new \DI\ContainerBuilder();
$container = $builder->build();

$container->set(ArticleRepository::class, function () {
    return new CombinedArticleRepository(
        new MysqlArticleRepository(),
        new NewsApiArticleRepository()
    );
});



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [ArticleController::class, 'index']);
    $r->addRoute('GET', '/articles', [ArticleController::class, 'index']);
    $r->addRoute('GET', '/articles/create', [ArticleController::class, 'create']);
    $r->addRoute('POST', '/articles', [ArticleController::class, 'store']);
    $r->addRoute('GET', '/articles/{id:\d+}', [ArticleController::class, 'show']);
    $r->addRoute('GET', '/articles/{id:\d+}/edit', [ArticleController::class, 'edit']);
    $r->addRoute('POST', '/articles/{id:\d+}', [ArticleController::class, 'update']);
    $r->addRoute('POST', '/articles/{id:\d+}/delete', [ArticleController::class, 'delete']);
});



$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $controller = $container->get($controller);
        $response = $controller->{$method}(...array_values($vars));

        switch (true)
        {
            case $response instanceof \App\ViewResponse:
                echo $twig->render($response->getViewName() . '.twig', $response->getData());
                break;
            case $response instanceof \App\RedirectResponse:
                header('Location: ' . $response->getLocation());
                break;
            default:
                break;
        }
        break;
}