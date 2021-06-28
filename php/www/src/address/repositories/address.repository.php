<?php
  require_once (__DIR__ . '/../dtos/address.dtos.php');
  require_once (__DIR__ . '/../../utils/ResponseMessage.php');
  class AddressRepository {
    public static function create(int $user_id, CreateAddressDto $createAddressDto): GetAddressDto {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO address
            (zipcode, 
             street, 
             neighbour, 
             city, 
             state, 
             country, 
             number, 
             owner_phone,
             owner_name,
             details, 
             customer_id)
            VALUES 
            (:zipcode, 
             :street, 
             :neighbour, 
             :city, 
             :state, 
             :country, 
             :number, 
             :owner_phone,
             :owner_name,
             :details, 
             :customer_id)
        ");

        $sql->bindparam(":zipcode", $createAddressDto->cep);
        $sql->bindparam(":street", $createAddressDto->street); 
        $sql->bindparam(":neighbour", $createAddressDto->neighbour); 
        $sql->bindparam(":city", $createAddressDto->city); 
        $sql->bindparam(":state", $createAddressDto->state); 
        $sql->bindparam(":country", $createAddressDto->country); 
        $sql->bindparam(":number", $createAddressDto->house_id);
        $sql->bindparam(":details", $createAddressDto->details);
        $sql->bindparam(":owner_phone", $createAddressDto->owner_phone);
        $sql->bindparam(":owner_name", $createAddressDto->owner_name);
        $sql->bindparam(":customer_id", $user_id);
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
          $createAddressDto->owner_phone,
          $createAddressDto->owner_name,
          false
        );
      } catch(Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
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
            $row['owner_phone'],
            $row['owner_name'],
            $row['default']
          );
        }
  
        return $address;
      } catch (\Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
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
            $row['customer_id'],
            $row['city'],
            $row['state'],
            $row['country'],
            $row['zipcode'],
            $row['street'],
            $row['neighbour'],
            $row['number'],
            $row['details'],
            $row['owner_phone'],
            $row['owner_name'],
            $row['default']
          );

          array_push($addresses, $address);
        }
  
        return $addresses;
      } catch (\Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function update(int $address_id, CreateAddressDto $updateAddressDto): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE address
            SET zipcode = :zipcode, 
                street = :street, 
                neighbour = :neighbour, 
                city = :city, 
                state = :state, 
                country = :country, 
                number = :number, 
                owner_phone = :owner_phone,
                owner_name = :owner_name,
                details = :details
          WHERE id = :id AND deleted_at is NULL");

        $sql->bindparam(":zipcode", $updateAddressDto->cep);
        $sql->bindparam(":street", $updateAddressDto->street); 
        $sql->bindparam(":neighbour", $updateAddressDto->neighbour); 
        $sql->bindparam(":city", $updateAddressDto->city); 
        $sql->bindparam(":state", $updateAddressDto->state); 
        $sql->bindparam(":country", $updateAddressDto->country); 
        $sql->bindparam(":number", $updateAddressDto->house_id);
        $sql->bindparam(":details", $updateAddressDto->details);
        $sql->bindparam(":owner_phone", $updateAddressDto->owner_phone);
        $sql->bindparam(":owner_name", $updateAddressDto->owner_name);
        $sql->bindparam(":id", $address_id);
        $sql->execute();


        return $sql->rowCount();
        /*
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
        );*/
      } catch(Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }          
    }

    public static function makeDefault(int $user_id, int $address_id): ResponseMessage {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE address
            SET address.default = 0
          WHERE customer_id = :customer_id AND deleted_at is NULL AND address.default = 1;
          UPDATE address
            SET address.default = 1 
          WHERE id = :id AND deleted_at is NULL;
       ");
        $sql->bindparam(":id", $address_id);
        $sql->bindparam(":customer_id", $user_id);

        $sql->execute();

        return new ResponseMessage("success", 201);
      } catch (\Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
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
        $toQuery = $now->format('Y-m-d H:i:s');
        $sql->bindParam(":now",$toQuery , PDO::PARAM_STR);
        $sql->bindparam(":id", $address_id);
        $sql->execute();
        

        return new ResponseMessage("success", 201);
      } catch (\Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }
?>