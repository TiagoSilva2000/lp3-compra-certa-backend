<?php
  require_once (__DIR__ . "/../services/auth.service.php");
  // require_once (__DIR__ . "/../../../utils/ControllerHelper.php");
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Exception\HttpUnauthorizedException;

class AuthController {

    public static function login(Request $request, Response $response, array $args) {
      $token =  $request->getHeader('Authorization')[0];

      if ($token == null) {
        throw new HttpUnauthorizedException($request);
      }
      $user = AuthService::login(substr($token, 7));
      if ($user == null) {
        throw new HttpUnauthorizedException($request);
      }

      return ControllerHelper::formatResponse($response, $user);
    }
    
    public static function logout(Request $request, Response $response, array $args) {

      return ControllerHelper::formatResponse($response, []);
    }
  }  

?>