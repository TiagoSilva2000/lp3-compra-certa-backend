<?php
  require_once (__DIR__ . '/../dtos/order-tracking.dtos.php');

  class OrderTrackingRepository {

    public static function create(int $orderId, CreateOrderTrackingDto $createOTDto): GetOrderTrackingDto {
      try {
        $formattedTime = $createOTDto->enterTime->format('Y-m-d H:i:s');
        $sql = Connection::$conn->prepare("
          INSERT INTO order_tracking 
            (order_id, order_status, enter_time, location_zipcode)
          VALUES
            (:order_id, :order_status, :enter_time, :location_zipcode)
        ");
        $sql->bindparam(":order_id", $orderId);
        $sql->bindparam(":order_status", $createOTDto->orderStatus);
        $sql->bindParam(":enter_time", $formattedTime);
        $sql->bindparam(":location_zipcode", $createOTDto->zipcode);
  
        $sql->execute();
        return new GetOrderTrackingDto (
          Connection::$conn->lastInsertId(),
          $orderId,
          $createOTDto->enterTime,
          $createOTDto->orderStatus,
          $createOTDto->zipcode
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
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
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }
  }



?>