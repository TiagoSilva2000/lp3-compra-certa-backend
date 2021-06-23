<?php
  require (__DIR__ . '/../entities/product.entity.php');
  require (__DIR__ . '/../../database/connection.php');  

  class ProductRepository {

    public static function list() {


    }

    public static function read(int $id) {
      try {
        $sql = Connection::$conn->prepare("SELECT * FROM user WHERE id = :id AND deleted_at is NULL");
        $user = null;
        $sql->bindparam(":id", $id);
        
        $sql->execute();
        while ($row = $sql->fetch()) {
          $user = new GetUserDto(
            $row['id'],
            $row['email'],
            $row['first_name'],
            $row['last_name'],
            $row['password'],
            $row['phone'],
            $row['cpf'],
            $row['user_type_id'],
          );
        }
  
        return $user;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }

?>