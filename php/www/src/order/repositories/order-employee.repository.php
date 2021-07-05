<?php
  require_once (__DIR__ . '/../dtos/employee-order.dtos.php');

  class OrderEmployeeRepository {

    public static function create(int $employeeId, int $orderId, string $order_status): GetEmployeeOrderDto {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO employee_orders_assigned
            (employee_id, order_id, order_status)
          VALUES
            (:employee_id, :order_id, :order_status)
        ");
        $sql->bindparam(":employee_id", $employeeId);
        $sql->bindparam(":order_id", $orderId);
        $sql->bindparam(":order_status", $order_status);  
        $sql->execute();
  
        return new GetEmployeeOrderDto(
          Connection::$conn->lastInsertId(),
          $employeeId,
          $orderId,
          $order_status,
          new DateTime()
        );
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

  }


?>