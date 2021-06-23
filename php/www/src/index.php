<?php
  require __DIR__ . '/vendor/autoload.php';
  use Dotenv\Dotenv;
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  require './user/controllers/user.controller.php';
  $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
  $dotenv->load();
  $conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], $_ENV['DB_PORT']);
  
  if ($conn->connect_error) {
    die('Could not connect: ' . mysqli_error($link));
  }

  echo "Database connected successfully at port " . $_ENV['DB_PORT'];

  AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  // ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  $app = AppFactory::create();

  $app->get('/account', \UserController::class . ':create');
  $app->get('/home', function (Request $request, Response $response) {  
    // $response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
    return $response;
});
  $app->run();
?>