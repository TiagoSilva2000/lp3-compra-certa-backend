<?php
  require_once (__DIR__ . '/vendor/autoload.php');
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  require_once ('./user/controllers/user.controller.php');
  require_once ('./order/controllers/order.controller.php');
  require_once ('./address/controllers/address.controller.php');
  require_once ('./product/controllers/product.controller.php');
  require_once ('./payment/controllers/payment.controller.php');
  require_once ('./auth/controllers/auth.controller.php');
  require_once ('./dash/controllers/dash.controller.php');


  AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
  $app = AppFactory::create();
  // ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);  

  
  $app->post('/users', \UserController::class . ':create');
  $app->get('/users/{id}', \UserController::class . ':read');
  $app->put('/users/{id}', \UserController::class . ':update');
  $app->delete('/users/{id}', \UserController::class . ':delete');
  $app->patch('/users/{id}', \UserController::class . ':recover');

  $app->get('/products/home', \ProductController::class . ':home');
  $app->get('/products', \ProductController::class . ':list');
  $app->get('/products/{id}', \ProductController::class . ':read');
  
  $app->get('/wishlist', \ProductController::class . ':listWishlist');
  $app->post('/product/{id}/wishlist', \ProductController::class . ':addToWishlist');
  $app->delete('/product/{id}/wishlist', \ProductController::class . ':removeFromWishlist');

  $app->post('/order', \OrderController::class, ':create');
  $app->get('/order/{id}', \OrderController::class, ':read');
  $app->get('/order', \OrderController::class, ':list');
  $app->patch('/order/{id}', \OrderController::class, ':updateStatus');
  $app->patch('/order/{id}/received', \OrderController::class, ':setReceived');
  $app->get('/order-control', \OrderController::class, ':controlList');
  $app->post('/order/{id}/rating', \OrderController::class, ':rate');

  $app->post('/payment', \PaymentController::class, ':create');
  $app->get('/payment/{id}', \PaymentController::class, ':read');
  $app->get('/payment', \PaymentController::class, ':list');
  $app->patch('/payment/{id}', \PaymentController::class, ':makeDefault');
  $app->delete('/payment/{id}', \PaymentController::class, ':delete');

  $app->post('/auth', \AuthController::class, ':login');
  $app->delete('/auth/{token}', \AuthController::class, ':logout');

  $app->get('/admin/dash', \DashController::class, ':dash');

  $app->get('/home', function (Request $request, Response $response) {  
    $response->getBody()->write('home');
    return $response;
  });
  
  Connection::connect();
  $app->run();
?>