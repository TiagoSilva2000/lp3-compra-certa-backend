<?php

  class WishlistRepository {

    public static function list(int $userId): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * 
            FROM wishlist as w
              JOIN product as p
                ON p.id = w.product_id
              JOIN media as m
                ON m.product_id = p.id AND m.main 
              JOIN price_history as ph 
                ON p.active_price_id = ph.id
            WHERE w.customer_id = :id");
            // WHERE p.deleted_at is NULL");
        $sql->bindParam(":id", $userId);
        $sql->execute();
        $products = [];

        while ($row = $sql->fetch()) {
          $product = new GetProductToHomeDto(
            $row['id'],
            $row['name'],
            $row['rating'],
            $row['type'],
            new GetMediaDto(
              $row['path'],
              $row['main']
            ),
            new GetPriceDto(
              $row['active_price'],
              $row['divided_max'],
              $row['payment_discount']
            )
          );
          array_push($products, $product);
        }

        return $products;
      } catch (Exception $e) {
        echo "Error: " . $sql->errorCode() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function add(int $productId, int $userId): ResponseMessage {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO wishlist 
            (customer_id, product_id) 
          VALUES 
            (:customer_id, :product_id)");
        $sql->bindParam(":customer_id", $userId);
        $sql->bindParam(":product_id", $productId);
        $sql->execute();

        return new ResponseMessage("success", 201);
      } catch (Exception $e) {
        echo "Error: " . $sql->errorCode() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function remove(int $productId, int $userId): ResponseMessage {
      try {
        $sql = Connection::$conn->prepare("
          DELETE FROM wishlist
          WHERE 
            product_id = :product_id AND customer_id = :customer_id");
        
          $sql->bindParam(":customer_id", $userId);
        $sql->bindParam(":product_id", $productId);
        $sql->execute();
        $products = [];

        return new ResponseMessage("success", 200);
      } catch (Exception $e) {
        echo "Error: " . $sql->errorCode() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }

?>