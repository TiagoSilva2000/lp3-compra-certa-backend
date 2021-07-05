<?php
  require_once (__DIR__ . '/../../database/connection.php');

  class OrderAssignedRepository {

    public static function create(int $emp_id, int $order_id, string $status) {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO employee_orders_assigned
            (employee_id, order_id, at, order_status)
            VALUES
            (:employee_id, :order_id, :at, :order_status)
        ");
        $now = new DateTime();
        $toQuery = $now->format('Y-m-d H:i:s');
        $sql->bindparam(":employee_id", $emp_id);
        $sql->bindparam(":order_id", $order_id);
        $sql->bindparam(":at", $toQuery);
        $sql->bindparam(":order_status", $status);
        $sql->execute();

        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }


  }



?>