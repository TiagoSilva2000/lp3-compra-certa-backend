<?php
  require_once (__DIR__ . "/../services/payment.service.php");
  require_once (__DIR__ . "/../enums/payment-method.enum.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class PaymentController {
    
    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();
      $payload = AuthService::getPayloadFromRequest($request);

      $createPaymentDto = new CreatePaymentDto(
        $body["name"],
        Paymentmethod::intToStr(PaymentMethod::$CREDIT_CARD),
        $body["owner_name"],
        substr($body["card_number"], -4),
        $body["due_date"],
        $body["ccv"]
      );
      
      $payment = PaymentService::create($payload->user_id, $createPaymentDto);
      return ControllerHelper::formatResponse($response, $payment);
    }

    public static function list(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $payments = PaymentService::list($payload->user_id);
      return ControllerHelper::formatResponse($response, $payments);
    }

    public static function read (Request $request, Response $response, array $args): Response {

      $payment = PaymentService::read(intval($args['id']));
      return ControllerHelper::formatResponse($response, $payment);
    }
    
    public static function makeDefault(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $message = PaymentService::makeDefault(intval($args['id']), $payload->user_id);
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function delete(Request $request, Response $response, array $args): Response {
      $message = PaymentService::delete(intval($args['id']));
      return ControllerHelper::formatResponse($response, $message);
    }
  }
?>