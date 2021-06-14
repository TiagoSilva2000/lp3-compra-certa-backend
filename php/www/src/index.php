<?php
  require __DIR__ . '/vendor/autoload.php';
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  require './user/controllers/user.controller.php';

  AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  // ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);

  $app = AppFactory::create();

  $app->get('/account', \UserController::class . ':create');
  $app->get('/user', function (Request $request, Response $response) {
    $response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
    return $response;
});
  $app->run();
?>