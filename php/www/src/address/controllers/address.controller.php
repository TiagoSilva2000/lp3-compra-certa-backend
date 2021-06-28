<?php
  require_once (__DIR__ . "/../services/address.service.php");
  require_once (__DIR__ . "/../services/../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class AddressController {

    public static function create(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();
      $payload = AuthService::getPayloadFromRequest($request);

      $createAddressDto = new CreateAddressDto(
        $body["cep"],
        $body["street"],
        $body["neighbour"],
        $body["city"],
        $body["state"],
        $body["country"],
        $body["house_id"],
        $body["details"],
        $body["owner_phone"],
        $body['owner_name']
      );
      $address = AddressService::create($payload->user_id, $createAddressDto);
      return ControllerHelper::formatResponse($response, $address);
    }

    public static function read(Request $request, Response $response, array $args): Response {
      
      $address = AddressService::read(intval($args["id"]));
      return ControllerHelper::formatResponse($response, $address);
    }

    public static function list(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $addresses = AddressService::list($payload->user_id);
      return ControllerHelper::formatResponse($response, $addresses);
    }

    public static function update(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $updateAddressDto = new CreateAddressDto(
        $body["cep"],
        $body["street"],
        $body["neighbour"],
        $body["city"],
        $body["state"],
        $body["country"],
        $body["house_id"],
        $body["details"],
        $body["owner_phone"],
        $body["owner_name"]
      );
      $address = AddressService::update(intval($args["id"]), $updateAddressDto);
      return ControllerHelper::formatResponse($response, $address);
    }

    public static function makeDefault(Request $request, Response $response, array $args): Response {
      $payload = AuthService::getPayloadFromRequest($request);

      $message = AddressService::makeDefault($payload->user_id, intval($args["id"]));
      return ControllerHelper::formatResponse($response, $message);
    }

    public static function delete(Request $request, Response $response, array $args): Response {
      
      $message = AddressService::delete(intval($args["id"]));
      return ControllerHelper::formatResponse($response, $message);
    }

  }


?>