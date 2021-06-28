<?php
  require_once (__DIR__ . '/../../database/connection.php');
  require_once (__DIR__ . '/../dtos/order.dtos.php');

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
          SELECT  p.id, p.name, p.rating, p.product_type_id, p.description,
                  p.stock, p.provider_id, p.sold_qnt,
                  ph.value, ph.divided_max, ph.payment_discount, ph.active,
                  m.path, m.ext, m.main,
                  op.op_rating, op.qnt  
          FROM order_products as op
            JOIN product as p
                ON p.id = op.product_id
            JOIN price_history as ph
                ON ph.product_id = p.id AND ph.active = 1
            LEFT OUTER JOIN media as m
                ON m.product_id = p.id AND m.main = 1
          WHERE order_id = :order_id
        ");
        $sql->bindParam(":order_id", $order_id);
        $sql->execute();
        $products = [];

        while ($row = $sql->fetch()) {
          $product = new GetOrderProductDto(
            new GetProductDto(
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
            ),
            $row["qnt"],
            $row["op_rating"]
          );

          array_push($products, $product);
        }
        return $products;
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function rate(int $order_id, int $product_id, float $rating): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE order_products
            SET op_rating = :rating
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