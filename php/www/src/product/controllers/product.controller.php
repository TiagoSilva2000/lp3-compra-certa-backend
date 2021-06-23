<?php
  require_once (__DIR__ . "/../services/product.service.php");
  // require_once (__DIR__ . "/../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  
  class ProductController {

    public static function home(Request $request, Response $response, array $args): Response {

      $products = ProductService::home();
      return ControllerHelper::formatResponse($response, $products);
    }

    public static function list(Request $request, Response $response, array $args): Response {

      $products = ProductService::list(); 
      return ControllerHelper::formatResponse($response, $products);
    }

    public static function read(Request $request, Response $response, array $args): Response {

      $product = ProductService::read($args['id']);
      return ControllerHelper::formatResponse($response, $product);
    }

  }
  


?>