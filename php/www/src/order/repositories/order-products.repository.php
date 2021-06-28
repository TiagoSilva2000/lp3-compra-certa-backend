<?php
  require_once (__DIR__ . '/../../database/connection.php');

  class OrderProductRepository {

    public static function create(int $order_id, int $product_id): int {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO order_products
            (order_id, product_Id)
          VALUES
            (:order_id, :product_id)
        ");
        $sql->bindParam(":order_id", $order_id);
        $sql->bindParam(":product_id", $product_id);
        $sql->execute();

        return Connection::$conn->lastInsertId();
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function list(int $order_id): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM order_products
          WHERE order_id = :order_id
        ");
        $sql->bindParam(":order_id", $order_id);
        $sql->execute();
        $product_ids = [];

        while ($row = $sql->fetch()) {
          array_push($product_ids, intval($row["product_id"]));
        }
        return $product_ids;
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function rate(int $order_id, int $product_id, float $rating): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE order_products
            SET rating = :rating
          WHERE order_id = :order_id AND product_id = :product_id
        ");
        $sql->bindParam(":order_id", $order_id);
        $sql->bindParam(":product_id", $product_id);
        $sql->bindParam(":rating", $rating);
        $sql->execute();

        return $sql->rowCount();
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }


  }



?>