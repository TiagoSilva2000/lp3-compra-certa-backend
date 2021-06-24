<?php
  require_once (__DIR__ . "/../services/payment.service.php");
  require_once (__DIR__ . "/../enums/payment-method.enum.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class PaymentController {
    
    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $createPaymentDto = new CreatePaymentDto(
        $body["name"],
        Paymentmethod::intToStr(PaymentMethod::$CREDIT_CARD),
        $body["owner_name"],
        $body["card_number"],
        $body["due_date"],
        $body["ccv"]
      );
      
      $payment = PaymentService::create(intval($args['user_id']), $createPaymentDto);
      return ControllerHelper::formatResponse($response, $payment);
    }

    public static function list(Request $request, Response $response, array $args): Response {
      
      $payments = PaymentService::list(intval($args['user_id']));
      return ControllerHelper::formatResponse($response, $payments);
    }

    public static function read (Request $request, Response $response, array $args): Response {

      $payment = PaymentService::read(intval($args['id']));
      return ControllerHelper::formatResponse($response, $payment);
    }
    
    public static function makeDefault(Request $request, Response $response, array $args): Response {
      $message = PaymentService::makeDefault(intval($args['id']));
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function delete(Request $request, Response $response, array $args): Response {
      $message = PaymentService::delete(intval($args['id']));
      return ControllerHelper::formatResponse($response, $message);
    }
  }
?>