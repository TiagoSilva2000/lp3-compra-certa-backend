<?php
  require __DIR__ . '/vendor/autoload.php';
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  require_once ('./user/controllers/user.controller.php');

  AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  
  $app = AppFactory::create();

  // ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  
  $app->post('/users', \UserController::class . ':create');
  $app->get('/users/{id}', \UserController::class . ':read');
  $app->put('/users/{id}', \UserController::class . ':update');
  $app->delete('/users/{id}', \UserController::class . ':delete');
  $app->patch('/users/{id}', \UserController::class . ':recover');

  $app->get('/home', function (Request $request, Response $response) {  
    $response->getBody()->write('home');
    return $response;
  });
  
  Connection::connect();
  $app->run();
?>