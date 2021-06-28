<?php

  class OrderRepository {
    public static function create(int $customer_id, GetOrderPaymentDto $payment, GetAddressDto $address): GetOrderDto {
      $order = null;
      $now = new DateTime();
      $formattedNow = $now->format('Y-m-d H:i:s');
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO compracertadb.order
            (customer_id, payment_id, address_id, ordered_at) 
          VALUES
            (:customer_id, :payment_id, :address_id, :ordered_at)
        ");
        $sql->bindparam(":customer_id", $customer_id);
        $sql->bindparam(":payment_id", $payment->id);
        $sql->bindparam(":address_id", $address->id);
        $sql->bindParam(":ordered_at", $formattedNow);
        $sql->execute();

        return new GetOrderDto(
          Connection::$conn->lastInsertId(),
          $customer_id,
          $now,
          null,
          null,
          []
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
    
    public static function list(int $userId): array {
      try {
        $sql = Connection::$conn->prepare("
            SELECT *, o.id as oid, a.id as aid, p.id as pid
                FROM compracertadb.order as o
                JOIN address as a
                    ON o.address_id = a.id
                JOIN payment as p
                    ON o.payment_id = p.id
            WHERE o.customer_id = :customer_id;
        ");

        $orders = [];
        $sql->bindParam(":customer_id", $userId);
        $sql->execute();

        while ($row = $sql->fetch()) {
          $order = new GetOrderDto(
            $row["oid"],
            $row["customer_id"],
            $row["ordered_at"],
            new GetAddressDto(
              $row['aid'],
              $row['customer_id'],
              $row['city'],
              $row['state'],
              $row['country'],
              $row['zipcode'],
              $row['street'],
              $row['neighbour'],
              $row['number'],
              $row['details'],
              $row['owner_phone'],
              $row['owner_name'],
              $row['default']
            ),
            new GetOrderPaymentDto(
              $row["pid"],
              $row["total"],
              $row["payment_status"]
            ),
            [],
            [],
            $row["received"],
          );

          array_push($orders, $order);
        }

        return $orders;
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function controlList(): array {
      try {
        $sql = Connection::$conn->prepare("
            SELECT * FROM compracertadb.order as o
                JOIN address as a
                    ON o.address_id = a.id
                JOIN payment as p
                    ON o.payment_id = p.id
            WHERE o.received != 1 AND active != 0
        ");
        $orders = [];
        $sql->execute();

        while ($row = $sql->fetch()) {
          $order = new GetOrderDto(
            $row["id"],
            $row["customer_id"],
            $row["ordered_at"],
            new GetAddressDto(
              $row['id'],
              $row['customer_id'],
              $row['city'],
              $row['state'],
              $row['country'],
              $row['zipcode'],
              $row['street'],
              $row['neighbour'],
              $row['number'],
              $row['details'],
              $row['owner_phone'],
              $row['owner_name'],
              $row['default']
            ),
            new GetOrderPaymentDto(
              $row["id"],
              $row["total"],
              $row["payment_status"]
            ),
            [],
            [],
            $row["received"],
          );
          array_push($orders, $order);
        }
          return $orders;
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function read(int $orderId): GetOrderDto|null {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM order_products as op
            JOIN order as o
              ON op.order_id = o.id
            JOIN address as a
              ON o.address_id = a.id
            JOIN payment as pay
              ON o.payment_id = pay.id 
            JOIN product as prod
              ON op.product_id = prod.id
            JOIN price_history as ph 
              ON prod.active_price_id = ph.id
          WHERE op.order_id = :id
        ");
        $order = null;
        $sql->bindparam(":id", $orderId);  
        $sql->execute();
        if ($row = $sql->fetch()) {
          $order = new GetorderDto(
            $row['order_id'],
            $row['customer_id'],
            $row['ordered_at'],
            new GetAddressDto(
              $row['id'],
              $row['customer_id'],
              $row['cep'], 
              $row['street'], 
              $row['neighbour'], 
              $row['city'], 
              $row['state'], 
              $row['country'], 
              $row['house_id'],
              $row['details'],
              $row['owner_phone']  
            ),
            new GetOrderPaymentDto(
              $row['id'],
              $row['total'],
              $row['status'],
            ),
            [
              new GetProductToHomeDto(
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
              )
            ]
          );
        }

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

          array_push($order->products, $product);
        }  

        return $order;
      } catch (\Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function setReceived(int $orderId): int  {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE compracertadb.order
            SET received = 1
          WHERE compracertadb.order.id = :order_id"
        );
        $sql->bindparam(":order_id", $orderId);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function rate(int $orderId, int $productId, float $rating): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE order_products as op
            SET op.rating = :rating 
          WHERE op.order_id = :order_id AND op.product_id = :product_id"
        );
        $sql->bindparam(":order_id", $orderId);
        $sql->bindparam(":product_id", $productId);
        $sql->bindparam(":rating", $rating);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }

?>