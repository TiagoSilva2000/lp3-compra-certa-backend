<?php

  class WishlistRepository {

    public static function list(int $userId): array {
      try {
        /*
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
        */
        $sql = Connection::$conn->prepare("
          SELECT p.id, p.name, p.rating, p.product_type_id, p.description,
             p.stock, p.provider_id, p.sold_qnt,
             ph.value, ph.divided_max, ph.payment_discount, ph.active,
             m.path, m.ext, m.main
          FROM product as p
          JOIN wishlist as w
            ON w.product_id = p.id AND w.customer_id = :customer_id
          JOIN price_history as ph
            ON ph.product_id = p.id AND ph.active = 1
          LEFT OUTER JOIN media as m
            ON m.product_id = p.id AND m.main = 1
        ");
        $sql->bindParam(":customer_id", $userId);
        $sql->execute();
        $products = [];

        while ($row = $sql->fetch()) {
          $product = new GetProductDto(
            $row['id'],
            $row['name'],
            $row['rating'],
            EProductType::intToStr($row['product_type_id']),
            $row['description'],
            $row['stock'],
            $row['provider_id'],
            $row['sold_qnt'],
            new GetPriceDto(
              $row["value"],
              $row["divided_max"],
              $row["payment_discount"],
              $row["active"]
            ),
            new GetMediaDto(
              $row["path"],
              $row["ext"],
              $row["main"]
            )
          );
          /*
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
          );*/
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