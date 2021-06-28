<?php
  require_once (__DIR__ . '/../dtos/product.dtos.php');
  require_once (__DIR__ . '/../../database/connection.php');

  class PriceHistoryRepository {

    public static function create(int $product_id, CreateProductPriceDto $createProductPriceDto): int {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO price_history
            (product_id, value, divided_max, payment_discount)
          VALUES
            (:product_id, :value, :divided_max, :payment_discount)
        ");
        $sql->bindParam(":product_id", $product_id);
        $sql->bindParam(":value", $createProductPriceDto->value);
        $sql->bindParam(":divided_max", $createProductPriceDto->divided_max);
        $sql->bindParam(":payment_discount", $createProductPriceDto->payment_discount);
        $sql->execute();

        return $sql->rowCount();
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

  }

?>