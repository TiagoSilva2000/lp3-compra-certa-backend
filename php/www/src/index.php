<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once('./database/connection.php');
require_once('./user/controllers/user.controller.php');
require_once('./order/controllers/order.controller.php');
require_once('./address/controllers/address.controller.php');
require_once('./product/controllers/product.controller.php');
require_once('./payment/controllers/payment.controller.php');
require_once('./auth/controllers/auth.controller.php');
require_once('./dash/controllers/dash.controller.php');
require_once('./utils/cors.php');

$log = new Logger('name');
$log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/error.log', 100));

AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);

$app = AppFactory::create();
$app->add(CorsMiddleware::class);
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true, $log);


//   $app->options('/{routes:.+}', function ($request, $response, $args) {
//     return $response;
//   });

// $app->add(function ($req, $res, $next) {
//     $response = $next($req, $res);
//     return $response
//             ->withHeader('Access-Control-Allow-Origin', '*')
//             ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
//             ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
// });


$app->post('/users', \UserController::class . ':create');
$app->get('/users/{id}', \UserController::class . ':read');
$app->put('/users/{id}', \UserController::class . ':update');
$app->delete('/users/{id}', \UserController::class . ':delete');
$app->patch('/users/{id}', \UserController::class . ':recover');

$app->options('/users', PreflightAction::class);
$app->options('/users/{id}', PreflightAction::class);

$app->get('/products/home', \ProductController::class . ':home');
$app->get('/products', \ProductController::class . ':list');
$app->get('/products/{id}', \ProductController::class . ':read');

$app->get('/wishlist', \ProductController::class . ':listWishlist');
$app->post('/product/{id}/wishlist', \ProductController::class . ':addToWishlist');
$app->delete('/product/{id}/wishlist', \ProductController::class . ':removeFromWishlist');

$app->post('/address', \PaymentController::class, ':create');
$app->get('/address/{id}', \PaymentController::class, ':read');
$app->get('/address', \PaymentController::class, ':list');
$app->put('/address/{id}', \PaymentController::class, ':update');
$app->patch('/address/{id}', \PaymentController::class, ':makeDefault');
$app->delete('/address/{id}', \PaymentController::class, ':delete');

$app->post('/payment', \PaymentController::class, ':create');
$app->get('/payment/{id}', \PaymentController::class, ':read');
$app->get('/payment', \PaymentController::class, ':list');
$app->patch('/payment/{id}', \PaymentController::class, ':makeDefault');
$app->delete('/payment/{id}', \PaymentController::class, ':delete');

$app->post('/order', \OrderController::class, ':create');
$app->get('/order', \OrderController::class, ':list');
$app->get('/order/{id}', \OrderController::class, ':read');
$app->patch('/order/{id}', \OrderController::class, ':updateStatus');
$app->patch('/order/{id}/received', \OrderController::class, ':setReceived');
$app->get('/order-control', \OrderController::class, ':controlList');
$app->post('/order/{id}/rating', \OrderController::class, ':rate');

$app->post('/auth', \AuthController::class, ':login');
$app->delete('/auth/{token}', \AuthController::class, ':logout');

$app->get('/admin/dash', \DashController::class, ':dash');

$app->get('/test', function (Request $request, Response $response) {
  $var = "x";
  return ControllerHelper::formatResponse($response, ['hello']);
});

$app->options('/test', PreflightAction::class);

Connection::connect();
$app->run();
?>