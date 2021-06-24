<?php
  require_once (__DIR__ . '/../entities/product.entity.php');
  require_once (__DIR__ . '/../../database/connection.php');  
  require_once (__DIR__ . '/../dtos/product.dtos.php');

  class ProductRepository {

    public static function home(): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * 
            FROM product as p
              JOIN media as m
                ON m.product_id = p.id AND m.main 
              JOIN price_history as ph 
                ON p.active_price_id = ph.id
        ");
            // WHERE p.deleted_at is NULL");
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

    public static function list(): array {
      try {
        $sql = Connection::$conn->prepare("SELECT * FROM product");
        $sql->execute();
        $products = [];

        while ($row = $sql->fetch()) {
          $product = new GetProductDto(
            $row['id'],
            $row['name'],
            $row['rating'],
            $row['description'],
            $row['password'],
            $row['phone'],
            $row['cpf'],
            $row['user_type_id'],
          );
          array_push($products, $product);
        }

        return $products;
      } catch (Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function read(int $id): GetProductDto|null {
      try {
        // $sql = Connection::$conn->prepare("SELECT * FROM product WHERE id = :id AND deleted_at is NULL");
        $sql = Connection::$conn->prepare("SELECT * FROM product WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $product = null;

        while ($row = $sql->fetch()) {
          $product = new GetProductDto(
            $row['id'],
            $row['name'],
            $row['rating'],
            $row['description'],
            $row['password'],
            $row['phone'],
            $row['cpf'],
            $row['user_type_id'],
          );
        }

        return $product;
      } catch (PDOException $e) {
        echo "Error: " . $e->getmessage() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }

?>