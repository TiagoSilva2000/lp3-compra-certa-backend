<?php
  use Firebase\JWT\JWT;

  require_once (__DIR__ . '/../repositories/auth.repository.php');
  require_once (__DIR__ . '/../../user/dtos/user.dtos.php');
  require_once (__DIR__ . '/../../user/services/user.service.php');
  class AuthService {

    public static function authenticate(string $token): bool {
      $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], array('HS256'));

      return AuthRepository::tokenExists($decoded->user_id, $token);
    }


    public static function createToken(int $userId, string $userRole): GetTokenDto {
      $payload = array(
        "user_id" => $userId,
        "user_role" => $userRole
      );
      $jwt = JWT::encode($payload, $_ENV['JWT_SECRET']);

      return AuthRepository::createToken($userId, $jwt);
    }

    public static function login(string $token): GetUserDto|null {
      $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], array('HS256'));
      
      return AuthRepository::tokenExists($decoded->user_id, $token) ?
        UserService::read($decoded->user_id) : null;
    }
    
    public static function logout() {

      return new ResponseMessage("success", 200);
    }

  }
?>