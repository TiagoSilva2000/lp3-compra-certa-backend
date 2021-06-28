<?php
  require_once (__DIR__ . '/../dtos/payment.dtos.php');

  class CreditCardRepository {

    public static function create(int $paymentId, CreatePaymentDto $createPaymentDto): GetCreditCardDto {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO credit_card
            (payment_options_id, owner_name, last_digits, due_date)
          VALUES
            (:payment_options_id, :owner_name, :last_digits, :due_date)
        ");

        $fixedLastdigits = substr($createPaymentDto->card_number, -4);
        $sql->bindparam(":payment_options_id", $paymentId);
        $sql->bindparam(":owner_name", $createPaymentDto->owner_name);
        $sql->bindparam(":last_digits", $fixedLastdigits);
        $sql->bindparam(":due_date", $createPaymentDto->due_date);
        $sql->execute();

        return new GetCreditCardDto(
          $createPaymentDto->owner_name,
          $createPaymentDto->card_number,
          $createPaymentDto->due_date
        );
        } catch (\Exception $e) {
          echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
          throw new Exception($e);
        }
    }


  }



?>