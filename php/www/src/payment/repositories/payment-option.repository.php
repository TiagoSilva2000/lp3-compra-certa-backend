<?php
  require_once (__DIR__ . '/../dtos/payment.dtos.php');

  class PaymentOptionRepository {
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
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
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
          $payment = new GetPaymentOptionDto(
            $row['id'],
            $row['name'],
            $row['payment_method'],
            $row['default'],
            new GetCreditCardDto (
              $row['owner_name'],
              $row['last_digits'],
              $row['due_date']
            )
          );
          array_push($payments, $payment);
        }

        return $payments;
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function read (int $paymentId): GetPaymentOptionDto|null {
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
          $payment = new GetPaymentOptionDto(
            $row['id'],
            $row['name'],
            $row['payment_method'],
            $row['default'],
            new GetCreditCardDto (
              $row['owner_name'],
              $row['last_digits'],
              $row['due_date']
            )
          );
          // $payment = new GetPaymentDto(
          //   $row['id'],
          //   $row['name'],
          //   $row['payment_method'],
          //   $row['default'],
          //   $row['owner_name'],
          //   $row['last_digits'],
          //   $row['due_date']
          // );
        }
        return $payment;
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
    
    public static function makeDefault(int $paymentId, int $user_id): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE payment_option
            SET payment_option.default = 0
          WHERE customer_id = :customer_id AND payment_option.default = 1;
          UPDATE payment_option
            SET payment_option.default = 1 
          WHERE id = :id
         ");
        $sql->bindparam(":id", $paymentId);
        $sql->bindparam(":customer_id", $user_id);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }

    public static function delete(int $paymentId): int {
      try {
        $sql = Connection::$conn->prepare("
          DELETE FROM credit_card
          WHERE payment_options_id = :payment_options_id;
          DELETE FROM payment_option
          WHERE id = :id
         ");
        $sql->bindparam(":payment_options_id", $paymentId);
        $sql->bindparam(":id", $paymentId);
        $sql->execute();
  
        return $sql->rowCount();
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }
?>