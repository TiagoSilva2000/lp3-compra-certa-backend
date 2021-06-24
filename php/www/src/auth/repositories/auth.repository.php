<?php
  require_once (__DIR__ . '/../dtos/token.dtos.php');

  class AuthRepository {

    public static function createToken(int $userId, string $token): GetTokenDto {
      $qnt = 0;
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO token
            (user_id, token)
          VALUES
            (:user_id, :token)
        ");
        $sql->bindparam(":user_id", $userId);
        $sql->bindparam(":token", $token);
        $sql->execute();
        
        return new GetTokenDto(
          $userId, 
          $token
        );
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function tokenExists(int $userId, string $token): bool {
      $qnt = 0;
      try {
        $sql = Connection::$conn->prepare("
          SELECT (COUNT(*)) FROM token 
          WHERE user_id = :id AND token = :token");
        $sql->bindparam(":id", $userId);
        $sql->bindparam(":token", $token);
        $sql->execute();
        
        $qnt = $sql->fetchColumn();
        return $qnt != 0;
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
    
    public static function deleteToken(int $tokenId): int {
      try {
        $sql = Connection::$conn->prepare("
          DELETE FROM token 
          WHERE id = :id");
        $sql->bindparam(":id", $tokenId);
        $sql->execute();
        
        return $sql->rowCount();
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

  }
?>