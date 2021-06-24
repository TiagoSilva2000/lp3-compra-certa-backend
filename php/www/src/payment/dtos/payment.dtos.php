<?php

  class GetPaymentOptionDto {
    public function __construct(
      public int $id,
      public string $name,
      public string $paymentMethod,
      public bool $default,
      public ?GetCreditCardDto $payment
    ) {}
  }

  

  class GetCreditCardDto {
    public function __construct(
      public string $owner_name,
      public string $last_digits,
      public string $due_date,
    ) {}
  }

  class CreatePaymentDto {
    public function __construct(
      public string $name,
      public string $paymentMethod,
      public string $owner_name,
      public string $card_number,
      public string $due_date,
      public string $ccv
    ) {}
  }

  class GetPaymentDto {
    public function __construct(
      public int $id,
      public string $name,
      public string $paymentMethod,
      public bool $default,
      public string $owner_name,
      public string $last_digits,
      public string $due_date,
    ) {}
  }

  class GetOrderPaymentDto {
    public function __construct(
      public int $id,
      public int $total,
      public string $status,
    ) {}
  }

?>