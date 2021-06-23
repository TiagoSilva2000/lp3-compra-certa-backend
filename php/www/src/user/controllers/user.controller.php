<?php
  require (__DIR__ . "/../services/user.service.php");
  require (__DIR__ . "/../entities/user.entity.php");
  require (__DIR__ . "../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  // require_once('../entities/user.entity.php');
  // require_once('../services/user.service.php');

  class UserController {

    public static function create(Request $request, Response $response): Response {
      $user = UserService::create();
      return ControllerHelper::formatResponse($response, $user);
    }

    public static function read(): User {
      return UserService::read();
    }

    public static function update(): User {
      return UserService::update();

    }
    
    public static function delete(): void {
      UserService::delete();
    }
  }

?>