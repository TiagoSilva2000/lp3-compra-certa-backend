<?php

  class SectorRepository {
    public static function create(int $order_id, time $total_time, date $date, int $sector ): GetTimePerSector {
      $time_per_sector = null;
      $now = new Date();
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO time_per_sector
            (order_id, total_time, date, sector)
          VALUES
            (:order_id, :total_time, :date, :sector)
        ");
        $sql->bindparam(":order_id", $customer_id);
        $sql->bindparam(":total_time", $total_time->id);
        $sql->bindparam(":sector", $sector->id);
        $sql->bindParam(":date", $now->format('Y-m-d'), PDO::PARAM_STR);
        $sql->execute();
  
        return new GetTimePerSector(
          Connection::$conn->lastInsertId(),
          $order_id,
          $now,
          $sector,
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
        $sql = Connection::$conn->prepare("SELECT * FROM time_per_sector");
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
            SELECT * FROM time_per_sector
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