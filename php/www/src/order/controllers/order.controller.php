<?php
  require_once (__DIR__ . "/../services/order.service.php");
  // require_once (__DIR__ . "../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class OrderController {

    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $order = OrderService::create(intval($args['customer_id']), new CreateOrderDto(
        $body['total'],
        $body['products'],
        $body['personal'],
        $body['payment'],
        $body['address']
      ));
      return ControllerHelper::formatResponse($response, $order);
    }
    
    public static function list(Request $request, Response $response, array $args): Response {
      
      $orders = OrderService::list(intval($args['customer_id']));
      return ControllerHelper::formatResponse($response, $orders);
    }

    public static function controlList(Request $request, Response $response): Response {
      
      $orders = OrderService::controlList();
      return ControllerHelper::formatResponse($response, $orders);
    }

    public static function read(Request $request, Response $response, array $args): Response {
      
      $order = OrderService::read(intval($args['orderId']));
      return ControllerHelper::formatResponse($response, $order);
    }

    public static function updateStatus(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $message = OrderService::updateStatus(intval($args['orderId']), $body['status']);
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function setReceived(Request $request, Response $response, array $args): Response {
      
      $message = OrderService::setReceived(intval($args['orderId']));
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function rate(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $message = OrderService::rate(intval($args['orderId']), $body['productId'], $body['rating']);
      return ControllerHelper::formatResponse($response, $message);
    }
  }

?>