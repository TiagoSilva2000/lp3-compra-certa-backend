<?php
  require_once (__DIR__ . '/../dtos/product-tracking.dtos.php');

  class OrderTrackingRepository {

    public static function create(int $orderId, CreateOrderTrackingDto $createPTDto): GetOrderTrackingDto {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO order_tracking 
            (order_id, order_status, enter_time, location_zipcode)
          VALUES
            (:order_id, :order_status, :enter_time, :location_zipcode)
        ");
        $sql->bindparam(":order_id", $orderId);
        $sql->bindparam(":order_status", $createPTDto->orderStatus);
        $sql->bindParam(":enter_time", $createPTDto->enterTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $sql->bindparam(":location_zipcode", $createPTDto->location_zipcode);
  
        $sql->execute();
        return new GetOrderTrackingDto (
          Connection::$conn->lastInsertId(),
          $orderId,
          $createPTDto->enterTime,
          $createPTDto->orderStatus,
          $createPTDto->location_zipcode
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function list(int $orderId): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM order_tracking
          WHERE order_id = :order_id
        ");
        $sql->bindparam(":order_id", $orderId);
        $sql->execute();
        $trackingPoints = [];

        while ($row = $sql->fetch()) {
          $tracking = new GetOrderTrackingDto (
            $row['id'],
            $row['order_id'],
            $row['enter_time'],
            $row['order_status'],
            $row['location_zipcode'],
          );
          
          array_push($trackingPoints, $tracking);
        }

        return $trackingPoints;
      } catch (\Exception $e) {
        echo "Error: " . $sql . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }



?>