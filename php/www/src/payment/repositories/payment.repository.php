<?php
  require_once (__DIR__ . '/../dtos/payment.dtos.php');

  class PaymentRepository {
    public static function create(int $userId, CreatePaymentDto $createPaymentDto): GetPaymentOptionDto {    
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO payment_option
            (customer_id, payment_method, name)
          VALUES
            (:customer_id, :payment_method, :name)
        ");
        $sql->bindparam(":customer_id", $userId);
        $sql->bindparam(":payment_method", $createPaymentDto->paymentMethod);
        $sql->bindparam(":name", $createPaymentDto->name);
        $sql->execute();

        return new GetPaymentOptionDto (
          Connection::$conn->lastInsertId(),
          $createPaymentDto->name,
          $createPaymentDto->paymentMethod,
          false,
          null
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function list(int $userId): array {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM payment_option as po
            JOIN credit_card as cc
              ON cc.payment_options_id = po.id
          WHERE po.customer_id = :id
        ");
        $sql->bindparam(":id", $userId);
        $sql->execute();
        $payments = [];

        while ($row = $sql->fetch()) {
          $payment = new GetPaymentDto(
            $row['id'],
            $row['name'],
            $row['payment_method'],
            $row['default'],
            $row['owner_name'],
            $row['last_digits'],
            $row['due_date']
          );

          array_push($payments, $payment);
        }

        return $payments;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function read (int $paymentId): GetPaymentDto|null {
      try {
        $sql = Connection::$conn->prepare("
          SELECT * FROM payment_option as po
            JOIN credit_card as cc
              ON cc.payment_options_id = po.id
          WHERE po.id = :id
        ");
        $sql->bindparam(":id", $paymentId);
        $sql->execute();
        $payment = null;

        while ($row = $sql->fetch()) {
          $payment = new GetPaymentDto(
            $row['id'],
            $row['name'],
            $row['payment_method'],
            $row['default'],
            $row['owner_name'],
            $row['last_digits'],
            $row['due_date']
          );
        }
        return $payment;
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
    
    public static function makeDefault(int $paymentId): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE payment_option
            SET default = true 
          WHERE id = :id");
        $sql->bindparam(":id", $paymentId);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function delete(int $paymentId): int {
      try {
        $sql = Connection::$conn->prepare("
          DELETE FROM payment_option
          WHERE id = :id");
        $sql->bindparam(":id", $paymentId);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }
?>