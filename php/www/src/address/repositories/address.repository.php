<?php
  require_once (__DIR__ . '/../dtos/address.dtos.php');
  require_once (__DIR__ . '/../../utils/ResponseMessage.php');
  class AddressRepository {
    public static function create(int $user_id, CreateAddressDto $createAddressDto): GetAddressDto {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO addresses
            (cep, street, neighbour, city, state, country, house_id, owner_phone, details, user_id)
            VALUES 
            (:cep, :street, :neighbour, :city, :state, :country, :house_id, :owner_phone, :details, :user_id)
        ");
        
        $sql->bindparam(":cep", $createAddressDto->cep); 
        $sql->bindparam(":street", $createAddressDto->street); 
        $sql->bindparam(":neighbour", $createAddressDto->neighbour); 
        $sql->bindparam(":city", $createAddressDto->city); 
        $sql->bindparam(":state", $createAddressDto->state); 
        $sql->bindparam(":country", $createAddressDto->country); 
        $sql->bindparam(":house_id", $createAddressDto->house_id);
        $sql->bindparam(":details", $createAddressDto->details);
        $sql->bindparam(":owner_phone", $createAddressDto->owner_phone);
        $sql->bindparam(":user_id", $user_id); 
        $sql->execute();
        
        return new GetAddressDto(
                        Connection::$conn->lastInsertId(),
                        $user_id,
                        $createAddressDto->cep, 
                        $createAddressDto->street, 
                        $createAddressDto->neighbour, 
                        $createAddressDto->city, 
                        $createAddressDto->state, 
                        $createAddressDto->country, 
                        $createAddressDto->house_id,
                        $createAddressDto->details,
                        $createAddressDto->owner_phone
        );
      } catch(Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }      
    }

    public static function read(int $address_id): GetAddressDto {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM address 
          WHERE id = :id AND deleted_at is NULL"
        );
        $address = null;
        $sql->bindparam(":id", $address_id);
        
        $sql->execute();
        while ($row = $sql->fetch()) {
          $address = new GetAddressDto(
            $row['id'],
            $row['user_id'],
            $row['cep'], 
            $row['street'], 
            $row['neighbour'], 
            $row['city'], 
            $row['state'], 
            $row['country'], 
            $row['house_id'],
            $row['details'],
            $row['owner_phone']
          );
        }
  
        return $address;
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function list(int $user_id): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM address 
          WHERE address.customer_id = :user_id AND deleted_at is NULL"
        );
        $addresses = [];
        $sql->bindparam(":user_id", $user_id);
        
        $sql->execute();
        while ($row = $sql->fetch()) {
          $address = new GetAddressDto(
            $row['id'],
            $row['user_id'],
            $row['cep'], 
            $row['street'], 
            $row['neighbour'], 
            $row['city'], 
            $row['state'], 
            $row['country'], 
            $row['house_id'],
            $row['details'],
            $row['owner_phone']
          );

          array_push($addresses, $address);
        }
  
        return $addresses;
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function update(int $address_id, CreateAddressDto $updateAddressDto): GetUpdatedAddressDto {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE address
            SET cep = :cep, 
                street = :street, 
                neighbour = :neighbour, 
                city = :city, 
                state = :state, 
                country = :country, 
                house_id = :house_id, 
                owner_phone = :owner_phone, 
                details = :details
          WHERE id = :id AND deleted_at is NULL");
        
        $sql->bindparam(":cep", $updateAddressDto->cep); 
        $sql->bindparam(":street", $updateAddressDto->street); 
        $sql->bindparam(":neighbour", $updateAddressDto->neighbour); 
        $sql->bindparam(":city", $updateAddressDto->city); 
        $sql->bindparam(":state", $updateAddressDto->state); 
        $sql->bindparam(":country", $updateAddressDto->country); 
        $sql->bindparam(":house_id", $updateAddressDto->house_id);
        $sql->bindparam(":details", $updateAddressDto->details);
        $sql->bindparam(":owner_phone", $updateAddressDto->owner_phone);
        $sql->bindparam(":id", $address_id); 
        $sql->execute();
        
        return new GetUpdatedAddressDto(
          Connection::$conn->lastInsertId(),
          $updateAddressDto->cep, 
          $updateAddressDto->street, 
          $updateAddressDto->neighbour, 
          $updateAddressDto->city, 
          $updateAddressDto->state, 
          $updateAddressDto->country, 
          $updateAddressDto->house_id,
          $updateAddressDto->details,
          $updateAddressDto->owner_phone
        );
      } catch(Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }          
    }

    public static function makeDefault(int $address_id): ResponseMessage {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE address
            SET default = 1 
          WHERE id = :id AND deleted_at is NULL"
        );
        $sql->bindparam(":id", $address_id);
        
        $sql->execute();

        return new ResponseMessage("success", 201);
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function delete(int $address_id): ResponseMessage {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE address
            SET deleted_at = :now 
          WHERE id = :id AND deleted_at IS NULL"
        );
        $now = new DateTime();
        $sql->bindParam(":now", $now->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $sql->bindparam(":id", $address_id);
        $sql->execute();
        

        return new ResponseMessage("success", 201);
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }
?>