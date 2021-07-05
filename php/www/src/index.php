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
$app->get('/users', \UserController::class . ':read');
$app->put('/users', \UserController::class . ':update');
$app->delete('/users', \UserController::class . ':delete');
$app->patch('/users', \UserController::class . ':recover');

$app->options('/users', PreflightAction::class);
$app->options('/users/{id}', PreflightAction::class);

$app->get('/products/home', \ProductController::class . ':list');
$app->post('/products', \ProductController::class . ':create');
$app->post('/products/{id}/medias', \ProductController::class . ':addMediasToProduct');
$app->patch('/products/{product_id}/medias/{id}', \ProductController::class . ':makeDefaultMedia');
$app->get('/products', \ProductController::class . ':list');
$app->get('/products/shopcart', \ProductController::class . ':listToShopcart');
$app->get('/products/{id}', \ProductController::class . ':read');
$app->patch('/products/{id}', \ProductController::class . ':rate');


$app->options('/products', PreflightAction::class);
$app->options('/products/{id}', PreflightAction::class);
$app->options('/products/{id}/medias', PreflightAction::class);
//$app->options('/products/home', PreflightAction::class);

$app->get('/wishlist', \ProductController::class . ':listWishlist');
$app->post('/wishlist/{id}', \ProductController::class . ':addToWishlist');
$app->delete('/wishlist/{id}', \ProductController::class . ':removeFromWishlist');
$app->options('/wishlist', PreflightAction::class);
$app->options('/wishlist/{id}', PreflightAction::class);

$app->post('/addresses', \AddressController::class . ':create');
$app->get('/addresses/{id}', \AddressController::class . ':read');
$app->get('/addresses', \AddressController::class . ':list');
$app->put('/addresses/{id}', \AddressController::class . ':update');
$app->patch('/addresses/{id}', \AddressController::class . ':makeDefault');
$app->delete('/addresses/{id}', \AddressController::class . ':delete');

$app->options('/addresses', PreflightAction::class);
$app->options('/addresses/{id}', PreflightAction::class);

$app->post('/payments', \PaymentController::class . ':create');
$app->get('/payments/{id}', \PaymentController::class . ':read');
$app->get('/payments', \PaymentController::class . ':list');
$app->patch('/payments/{id}', \PaymentController::class . ':makeDefault');
$app->delete('/payments/{id}', \PaymentController::class . ':delete');

$app->options("/payments", PreflightAction::class);
$app->options("/payments/{id}", PreflightAction::class);

$app->post('/orders', \OrderController::class . ':create');
$app->get('/orders', \OrderController::class . ':list');
$app->get('/orders/{id}', \OrderController::class . ':read');
$app->post('/orders/{id}/{status}', \OrderController::class . ':updateStatus');
$app->patch('/orders/{id}/received', \OrderController::class . ':setReceived');
$app->get('/order-controls', \OrderController::class . ':controlList');
$app->post('/rating/{order_id}', \OrderController::class . ':rate');

$app->options("/orders", PreflightAction::class);
$app->options("/order-controls", PreflightAction::class);
$app->options("/orders/{id}", PreflightAction::class);
$app->options("/orders/{id}/{status}", PreflightAction::class);
$app->options("/rating/{order_id}", PreflightAction::class);

$app->post('/auths', \AuthController::class . ':login');
$app->delete('/auths/{token}', \AuthController::class . ':logout');
$app->options('/auths', PreflightAction::class);
$app->options('/auths/{token}', PreflightAction::class);


$app->get('/admin/dash', \DashController::class . ':dash');

$app->get('/test', function (Request $request, Response $response) {
  $var = "x";
  return ControllerHelper::formatResponse($response, ['hello']);
});

$app->options('/test', PreflightAction::class);

Connection::connect();
$app->run();
?>