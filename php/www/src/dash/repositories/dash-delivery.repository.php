<?php

  class SectorRepository {
    public static function create(int $order_id, time $total_time, date $date): GetDeliveryTime {
      $delivery_time = null;
      $now = new Date();
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO delivery_time
            (order_id, total_time, date)
          VALUES
            (:order_id, :total_time, :date)
        ");
        $sql->bindparam(":order_id", $customer_id);
        $sql->bindparam(":total_time", $total_time->id);
        $sql->bindParam(":date", $now->format('Y-m-d'), PDO::PARAM_STR);
        $sql->execute();
  
        return new GetDeliveryTime(
          Connection::$conn->lastInsertId(),
          $order_id,
          $now,
          null,
          []
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
    
    public static function list(): array {
      try {
        $sql = Connection::$conn->prepare("SELECT * FROM delivery_time");
        $time_per_sector = [];
        $sql->execute();
  
        return $time_per_sector;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function getByMonth(str $month): array {
      try {
        $sql = Connection::$conn->prepare(`
            SELECT * FROM delivery_time
                WHERE date LIKE '_____:month___'
        `);
        $timeSectorByMonth = [];
        $sql->execute();
        return $timeSectorByMonth;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

?>