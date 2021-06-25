<?php
  require_once (__DIR__ . '/../entities/user.entity.php');
  require_once (__DIR__ . '/../../database/connection.php');  
  class UserRepository {
    public static function createUser(CreateUserDto $createUserDto): GetUserDto {
      $role = UserType::intToStr($createUserDto->user_type);
      $sql = Connection::$conn->prepare("INSERT INTO user (email, first_name, last_name, password, phone, cpf, user_type)
              VALUES (:email, :first_name, :last_name, :password, :phone, :cpf, :user_type)");
      $sql->bindParam(":email", $createUserDto->email);
      $sql->bindparam(":first_name", $createUserDto->first_name);
      $sql->bindparam(":last_name", $createUserDto->last_name);
      $sql->bindparam(":password", $createUserDto->password);
      $sql->bindparam(":phone", $createUserDto->phone);
      $sql->bindparam(":cpf", $createUserDto->cpf);
      $sql->bindparam(":user_type", $role);
      try {
        $sql->execute();
        
        return new GetUserDto(
          Connection::$conn->lastInsertId(),
          $createUserDto->email, 
          $createUserDto->first_name, 
          $createUserDto->last_name, 
          $createUserDto->password, 
          $createUserDto->phone, 
          $createUserDto->cpf,
          $createUserDto->user_type
        );
      } catch(Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }      
    }
    
    public static function read(int $id): GetUserDto|null {
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

    public static function readByEmail(string $email): GetUserDto|null {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM user 
          WHERE email = :email AND deleted_at is NULL
        ");
        $user = null;
        $sql->bindparam(":email", $email);
        
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

    public static function update(int $id, UpdateuserDto $updateuserDto): GetUserDto|null {
      try {

        $sql = Connection::$conn->prepare("UPDATE user SET email = :email, first_name = :first_name, last_name = :last_name, phone = :phone, cpf = :cpf WHERE id = :id AND deleted_at is NULL");
        $user = null;
        $sql->bindparam(":id", $id);

        $sql->bindParam(":email", $updateuserDto->email);
        $sql->bindparam(":first_name", $updateuserDto->first_name);
        $sql->bindparam(":last_name", $updateuserDto->last_name);
        $sql->bindparam(":phone", $updateuserDto->phone);
        $sql->bindparam(":cpf", $updateuserDto->cpf);
  
        $sql->execute();
  
        return $user;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function delete(int $id): GetUserDto|null {
      try {

        $sql = Connection::$conn->prepare("UPDATE user SET deleted_at = :deleted_at WHERE id = :id AND deleted_at is NULL");
        $user = null;
        $sql->bindparam(":id", $id);
        $now = new DateTime();
        $nowToDb =  $now->format('Y-m-d H:i:s');
        $sql->bindParam(":deleted_at", $nowToDb, PDO::PARAM_STR);
  
        $sql->execute();
  
        return $user;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function recover(int $id): GetUserDto|null {
      try {
        echo $id;
        $sql = Connection::$conn->prepare("UPDATE user SET deleted_at = null WHERE id = :id AND deleted_at is not NULL");
        $user = null;
        $sql->bindparam(":id", $id);  
        $sql->execute();
  
        return $user;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }
?>