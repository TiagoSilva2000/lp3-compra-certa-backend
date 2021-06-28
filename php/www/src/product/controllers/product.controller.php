<?php
  require_once (__DIR__ . "/../services/product.service.php");
  require_once (__DIR__ . "/../services/wishlist.service.php");
  // require_once (__DIR__ . "/../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class ProductController {

    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getParsedBody();
      $createProductDtos = [];
      $a =  $body[0]["media"];

      echo $body[0]["price"];

      foreach ($body as &$item) {
        $createProductDto = new CreateProductDto(
          $item['name'],
          $item['description'],
          $item['stock'],
          $item['provider_id'],
          $item['product_type_id'],
          new CreateProductPriceDto(
            $item["price"]["value"],
            $item["price"]["divided_max"],
            $item["price"]["payment_discount"]
          )
        );
        array_push($createProductDtos, $createProductDto);
      }


      $products = ProductService::createMany($createProductDtos);
      return ControllerHelper::formatResponse($response, $products);
    }



    public static function addMediasToProduct(Request $request, Response $response, array $args): Response {
      $body = $request->getParsedBody();
      $mediasDtos = [];
      foreach ($body as &$bodyUnit) {
        //echo $bodyUnit["path"] . " " . $bodyUnit["ext"] . " " . $bodyUnit["main"];
        array_push($mediasDtos, new CreateProductMediaDto(
          $bodyUnit["path"],
          $bodyUnit["ext"],
          $bodyUnit["main"],
        ));
      }

      $message = ProductService::addMediasToProduct(intval($args["id"]), $mediasDtos);
      return ControllerHelper::formatResponse($response, $message);
    }
    
    public static function makeMediaDefaults(Request $request, Response $response, array $args) {
        
    }

    public static function list(Request $request, Response $response, array $args): Response {

      $products = ProductService::list(); 
      return ControllerHelper::formatResponse($response, $products);
    }

  /**
   * @throws HttpBadRequestException
   */
  public static function listToShopcart(Request $request, Response $response, array $args): Response {
      $params = $request->getQueryParams();
      if ($params["ids"] == null) {
        throw new HttpBadRequestException($request);
      }


      $products = ProductService::listToShopcart($params["ids"]);
      return ControllerHelper::formatResponse($response, $products);
    }

    public static function read(Request $request, Response $response, array $args): Response {

      $product = ProductService::read($args['id']);
      return ControllerHelper::formatResponse($response, $product);
    }

    public static function listWishlist(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $products = WishlistService::list($payload->user_id);
      return ControllerHelper::formatResponse($response, $products);
    }

    public static function addToWishlist(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $message = WishlistService::add($args['id'], $payload->user_id);
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function removeFromWishlist(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);


      $message = WishlistService::remove($args['id'], $payload->user_id);
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function rate(Request $request, Response $response){


      //$message = ProductService::rate();
      $message = ['hello'];
      return ControllerHelper::formatResponse($response, $message);
    }


  }
  


?>