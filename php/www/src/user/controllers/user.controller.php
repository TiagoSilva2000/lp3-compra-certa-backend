<?php
  require (__DIR__ . "/../services/user.service.php");
  require (__DIR__ . "../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  class UserController {

    public static function create(Request $request, Response $response): Response {
      $body = $request->getparsedBody();

      $createUserDto = new CreateUserDto(
        $body["email"],
        $body["first_name"],
        $body["last_name"],
        $body["password"],
        $body["phone"],
        $body["cpf"],
        intval($body["user_type"])
      );
      
      $user = UserService::create($createUserDto);
      return ControllerHelper::formatResponse($response, $user);
    }

    public static function read(Request $request, Response $response, array $args): Response {

      $user = UserService::read(intval($args["id"]));
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

      $user = UserService::update(intval($args["id"]), $updateUserDto);
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