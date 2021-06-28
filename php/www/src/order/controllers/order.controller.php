<?php
  require_once (__DIR__ . "/../services/order.service.php");
  require_once (__DIR__ . "/../dtos/order.dtos.php");
  // require_once (__DIR__ . "../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class OrderController {

    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();
      $payload = AuthService::getPayloadFromRequest($request);


      $createOrderDto = new CreateOrderDto(
        $body['total'],
        $body['products'],
        new CreateOrderPersonalDto(
          $body["personal"]["id"],
          $body["personal"]["name"],
          $body["personal"]["cpf"],
          $body["personal"]["email"]
        ),
        new CreateOrderPaymentDto(
          $body["payment"]["id"],
          $body["payment"]["name"],
          $body["payment"]["owner_name"],
          $body["payment"]["card_number"],
          $body["payment"]["due_date"],
          $body["payment"]["ccv"],
        ),
        new CreateOrderAddressDto(
          $body["address"]["id"],
          $body["address"]["cep"],
          $body["address"]["street"],
          $body["address"]["neighbour"],
          $body["address"]["city"],
          $body["address"]["state"],
          $body["address"]["country"],
          $body["address"]["house_id"],
          $body["address"]["details"],
          $body["address"]["owner_phone"]
        ));
      $order = OrderService::create($payload->user_id, $createOrderDto);
      return ControllerHelper::formatResponse($response, $order);
    }
    
    public static function list(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $orders = OrderService::list($payload->user_id);
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
      //$payload = AuthService::getPayloadFromRequest($request);
      /*
        if ($payload->user_role != UserType::$EMPLOYEE) {
         throw new HttpUnauthorizedException($request);
      }*/
      $body = $request->getparsedBody();

      $message = OrderService::updateStatus(intval($args['id']), $args['status']);

      return ControllerHelper::formatResponse($response, $message);
    }

    public static function setReceived(Request $request, Response $response, array $args): Response {
      
      $message = OrderService::setReceived(intval($args['id']));
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function rate(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $message = OrderService::rate(intval($args['order_id']), intval($body['product_id']), $body['rating']);
      return ControllerHelper::formatResponse($response, $message);
    }
  }

?>