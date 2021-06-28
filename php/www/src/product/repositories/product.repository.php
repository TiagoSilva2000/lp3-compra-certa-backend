<?php
  require_once (__DIR__ . '/../entities/product.entity.php');
  require_once (__DIR__ . '/../../database/connection.php');  
  require_once (__DIR__ . '/../dtos/product.dtos.php');
  require_once (__DIR__ . '/../enums/product-type.enum.php');

  class ProductRepository {

    public static function create(CreateProductDto $createProductDto): int {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO product
            (name, description, stock, provider_id, product_type_id)
          VALUES
            (:name, :description, :stock, :provider_id, :product_type_id)
        ");
        $sql->bindParam(":name", $createProductDto->name);
        $sql->bindParam(":description", $createProductDto->description);
        $sql->bindParam(":stock", $createProductDto->stock);
        $sql->bindParam(":provider_id", $createProductDto->provider_id);
        $sql->bindParam(":product_type_id", $createProductDto->product_type_id);
        $sql->execute();

        return Connection::$conn->lastInsertId();
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }


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

    public static function list(string $ids = null): array {
      //$whereString = "WHERE p.id IN (";

      try {
        $sql = Connection::$conn->prepare("
            SELECT p.id, p.name, p.rating, p.product_type_id, p.description,
                   p.stock, p.provider_id, p.sold_qnt,
                   ph.value, ph.divided_max, ph.payment_discount, ph.active,
                   m.path, m.ext, m.main
                FROM product as p
                JOIN price_history as ph
                    ON ph.product_id = p.id AND ph.active = 1
                LEFT OUTER JOIN media as m
                    ON m.product_id = p.id AND m.main = 1
        ");
        //$sql->bindParam(":ids", $ids);
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
          array_push($products, $product);
        }

        return $products;
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function read(int $id): GetProductDto|null {
      try {
        $sql = Connection::$conn->prepare("
          SELECT  p.id, p.name, p.rating, p.product_type_id, p.description,
                  p.stock, p.provider_id, p.sold_qnt,
                  ph.value, ph.divided_max, ph.payment_discount, ph.active,
                  m.path, m.ext, m.main
          FROM product as p
            JOIN price_history as ph
              ON ph.product_id = p.id AND ph.active = 1
            LEFT OUTER JOIN media as m
              ON m.product_id = p.id AND m.main = 1
          WHERE p.id = :id
        ");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $product = null;

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
        }

        return $product;
      } catch (PDOException $e) {
        echo "Error: " . $e->getmessage() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }

?>