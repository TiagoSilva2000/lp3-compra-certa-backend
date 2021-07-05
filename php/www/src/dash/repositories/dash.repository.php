<?php

  class DashRepository {

    public static function loadAvgSectorTime() {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM order_tracking
        ");
        $sql->execute();

        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function loadDeliveryTime() {
      try {
        $sql = Connection::$conn->prepare("
          SELECT  id, 
                  UNIX_TIMESTAMP(received_at) - UNIX_TIMESTAMP(ordered_at) as diff
          FROM compracertadb.order
          WHERE received_at is not null;
        ");
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function loadMostSoldProducts() {
      try {
        $sql = Connection::$conn->prepare("
          SELECT *
            FROM product
          ORDER BY sold_qnt DESC
          LIMIT 5;
        ");
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function loadMostClient() {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * 
            FROM customer
          ORDER BY total_bought DESC
          LIMIT 5;
        ");
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }
?>