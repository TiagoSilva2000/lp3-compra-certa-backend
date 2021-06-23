<?php
  require (__DIR__ . "/../services/product.service.php");
  require (__DIR__ . "../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  
  class ProductController {

    public static function list(Request $request, Response $response, array $args): Response {


      // $products = Product;
      return ControllerHelper::formatResponse($response, $products);
    }

    public static function read(Request $request, Response $response, array $args): Response {


      // $user = UserService::create($createUserDto);
      return ControllerHelper::formatResponse($response, $user);
    }

  }
  


?>