<?php
  require_once (__DIR__ . "/../services/user.service.php");
  require_once (__DIR__ . "/../enums/user-type.enum.php");
  require_once (__DIR__ . "/../../auth/services/auth.service.php");
  // require_once (__DIR__ . "/../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  class UserController {

    public static function create(Request $request, Response $response): Response {
      $body = $request->getparsedBody();
      $createUserDto = new CreateUserDto(
        $body["email"],
        $body["first_name"] ?? "",
        $body["last_name"] ?? "",
        $body["password"],
        $body["phone"] ?? "",
        $body["cpf"] ?? "",
        UserType::$CUSTOMER
      );
      
      $user = AuthService::signup($createUserDto);
      return ControllerHelper::formatResponse($response, $user);
    }

    public static function read(Request $request, Response $response, array $args): Response {

      $payload = AuthService::getPayloadFromRequest($request);
      $user = UserService::read($payload->user_id);
      return ControllerHelper::formatResponse($response, $user);
    }

    public static function update(Request $request, Response $response, array $args): Response {
      $body = $request->getparsedBody();

      $updateUserDto = new UpdateUserDto(
        $body["email"],
        $body["first_name"],
        $body["last_name"],
        $body["phone"],
        $body["cpf"],
      );
      $payload = AuthService::getPayloadFromRequest($request);


      $user = UserService::update($payload->user_id, $updateUserDto);
      return ControllerHelper::formatResponse($response, $user);
    }
    
    public static function delete(Request $request, Response $response, array $args): Response {
      $user = UserService::delete(intval($args["id"]));
      return ControllerHelper::formatResponse($response, $user);
    }

    public static function recover(Request $request, Response $response, array $args): Response {
      $user = UserService::recover(intval($args["id"]));
      return ControllerHelper::formatResponse($response, $user);
    }
  }

?>