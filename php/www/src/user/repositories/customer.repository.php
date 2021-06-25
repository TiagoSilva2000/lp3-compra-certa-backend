<?php
  require_once(__DIR__ . '/../dtos/customer.dtos.php');
  class CustomerRepository {

    public static function createCustomer(int $user_id): GetCustomerDto  {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO customer 
            (:user_id)
          VALUES 
            (:user_id)"
        );
        $sql->bindParam(":user_id", $user_id);    
        $sql->execute();
      
        return new GetCustomerDto (
          $user_id, 
          0,
          0
        );
      } catch(Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }      
    }
  }

?>