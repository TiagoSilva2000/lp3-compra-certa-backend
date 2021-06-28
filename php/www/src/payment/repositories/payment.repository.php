<?php
  require_once (__DIR__ . '/../enums/payment-status.enum.php');
  require_once (__DIR__ . '/../dtos/payment.dtos.php');

  class PaymentRepository {

    public static function create(int $paymentOptionId, int $total): GetOrderPaymentDto {    
      $status = PaymentStatus::intToStr(PaymentStatus::$PAID);
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO payment
            (total, payment_status, payment_options_id)
          VALUES
            (:total, :status, :payment_option_id)
        ");
        $sql->bindparam(":total", $total);
        $sql->bindparam(":status", $status);
        $sql->bindparam(":payment_option_id", $paymentOptionId);
        $sql->execute();

        return new GetOrderPaymentDto(
          Connection::$conn->lastInsertId(),
          $total,
          $status
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }
  }
  

?>