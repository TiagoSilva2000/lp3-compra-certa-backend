<?php
  use Firebase\JWT\JWT;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Exception\HttpUnauthorizedException;

require_once (__DIR__ . '/../repositories/auth.repository.php');
  require_once (__DIR__ . '/../../user/dtos/user.dtos.php');
  require_once (__DIR__ . '/../../user/services/user.service.php');


  class AuthService {


    /**
     * @throws HttpUnauthorizedException
     * @throws Exception
     */
    public static function getPayloadFromRequest(Request $request): GetTokenPayload {
      $token =  $request->getHeader('Authorization')[0];

      if ($token == null) {
        throw new HttpUnauthorizedException($request);
      }

      return self::getPayloadFromToken(substr($token, 7));
    }


    public static function getPayloadFromToken(string $token): GetTokenPayload {
      try {
        $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], array('HS256'));

        return new GetTokenPayload(
          $decoded->user_id,
          $decoded->user_role,
          $decoded->user_first_name
        );
      } catch (Exception $e) {
        throw new Exception($e->getMessage());
      }
    }

    public static function authenticate(string $token): bool {
      $decoded = self::getPayloadFromToken($token);

      return AuthRepository::tokenExists($decoded->user_id, $token);
    }


    public static function createToken(int $userId, string $userRole, string $user_first_name): GetTokenDto {
      $payload = array(
        "user_id" => $userId,
        "user_role" => $userRole,
        "user_first_name" => $user_first_name
      );
      $jwt = JWT::encode($payload, $_ENV['JWT_SECRET']);

      return AuthRepository::createToken($userId, $jwt);
    }

    public static function signup(CreateUserDto $createUserDto): GetAuthResponse {
      $user = UserService::create($createUserDto);
      $token = self::createToken($user->id, UserType::intToStr($user->user_type), $user->first_name);

      return new GetAuthResponse(
        $user,
        $token
      );
    }

    public static function login(string $email, string $password): GetAuthResponse|null {
      $user = UserService::checkUserCredentials($email, $password);
      $token = self::createToken($user->id, $user->user_type, $user->first_name);
      $wishlist = WishlistService::list($user->id);
      $favs = [];

      foreach($wishlist as &$w) {
        array_push($favs, $w->id);
      }


      return new GetAuthResponse(
        $user,
        $token,
        $favs
      );
    }

    // public static function login(string $token): GetUserDto|null {
    //   $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], array('HS256'));
      
    //   return AuthRepository::tokenExists($decoded->user_id, $token) ?
    //     UserService::read($decoded->user_id) : null;
    // }
    
    public static function logout() {

      return new ResponseMessage("success", 200);
    }

  }
?>