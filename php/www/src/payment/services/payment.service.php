<?php
  require_once (__DIR__ . '/../repositories/payment-option.repository.php');
  require_once (__DIR__ . '/../repositories/credit-card.repository.php');
  require_once (__DIR__ . '/../repositories/payment.repository.php');

  class PaymentService {
    
    public static function create(int $userId, CreatePaymentDto $createPaymentDto): GetPaymentOptionDto {      
      $paymentOption = PaymentOptionRepository::create($userId, $createPaymentDto);
      $credit_card = CreditCardRepository::create($paymentOption->id, $createPaymentDto);

      $paymentOption->payment = $credit_card;
      return $paymentOption;
    }

    public static function createPayment(int $paymentOptionId, int $total) {
      return PaymentRepository::create($paymentOptionId, $total);
    }

    public static function findOrCreate(int $customer_id, CreateOrderPaymentDto $createOrderPaymentDto): GetPaymentOptionDto {
      $payment = null;
      if ($createOrderPaymentDto->id != null) {
        $payment = PaymentService::read($createOrderPaymentDto->id);
      } 

      if ($payment == null) {
        $payment = PaymentService::create($customer_id, new CreatePaymentDto(
          $createOrderPaymentDto->name,
          PaymentMethod::intToStr(PaymentMethod::$CREDIT_CARD),
          $createOrderPaymentDto->owner_name,
          substr($createOrderPaymentDto->card_number, -4),
          $createOrderPaymentDto->due_date,
          $createOrderPaymentDto->ccv,
        ));
      }
      return $payment;
    }

    public static function list(int $userId): array {

      return PaymentOptionRepository::list($userId);
    }

    public static function read (int $paymentId): GetPaymentOptionDto|null {

      return PaymentOptionRepository::read($paymentId);
    }
    
    public static function makeDefault(int $paymentId, int $user_id): ResponseMessage {
      $message = new ResponseMessage("success", 200);
      $rowsAffected = PaymentOptionRepository::makeDefault($paymentId, $user_id);

      /*
      if ($rowsAffected == 0) {
        $message = new ResponseMessage("error", 500);
      }*/

      return $message;
    }

    public static function delete(int $paymentId): ResponseMessage {
      $message = new ResponseMessage("success", 200);
      $rowsAffected = PaymentOptionRepository::delete($paymentId);

      if ($rowsAffected != 1) {
        $message = new ResponseMessage("error", 500);
      }

      return $message;
    }
   
  }

?>