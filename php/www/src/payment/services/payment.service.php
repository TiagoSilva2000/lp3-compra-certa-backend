<?php
  require_once (__DIR__ . '/../repositories/payment.repository.php');
  require_once (__DIR__ . '/../repositories/credit-card.repository.php');

  class PaymentService {
      public static function create(int $userId, CreatePaymentDto $createPaymentDto): GetPaymentOptionDto {      
      $paymentOption = PaymentRepository::create($userId, $createPaymentDto);
      $credit_card = CreditCardRepository::create($userId, $createPaymentDto);

      $paymentOption->payment = $credit_card;
      return $paymentOption;
    }

    public static function list(int $userId): array {

      return PaymentRepository::list($userId);
    }

    public static function read (int $paymentId): GetPaymentDto|null {

      return PaymentRepository::read($paymentId);
    }
    
    public static function makeDefault(int $paymentId): ResponseMessage {
      $message = new ResponseMessage("success", 200);
      $rowsAffected = PaymentRepository::makeDefault($paymentId);

      if ($rowsAffected != 1) {
        $message = new ResponseMessage("error", 500);
      }

      return $message;
    }

    public static function delete(int $paymentId): ResponseMessage {
      $message = new ResponseMessage("success", 200);
      $rowsAffected = PaymentRepository::delete($paymentId);

      if ($rowsAffected != 1) {
        $message = new ResponseMessage("error", 500);
      }

      return $message;
    }
   
  }

?>