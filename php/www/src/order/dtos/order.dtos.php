<?php
  require_once (__DIR__ . '/../../address/dtos/address.dtos.php');
  require_once (__DIR__ . '/../../payment/dtos/payment.dtos.php');
  //require_once (__DIR__ . '/../dtos/order-tracking.dtos.php');

  class CreateOrderPersonalDto {
    public function __construct(
      public ?int $id = null,
      public ?string $name,
      public ?string $cpf,
      public ?string $email,
    ) {}
  }
  class CreateOrderAddressDto {
    public function __construct(
      public ?int $id = null,
			public ?string $cep,
			public ?string $street,
			public ?string $neighbour,
			public ?string $city,
			public ?string $state,
			public ?string $country,
			public ?string $house_id,
			public ?string $details,
			public ?string $owner_phone,
    ) {}
  }

  class CreateOrderPaymentDto {
    public function __construct(
      public ?int $id = null,
      public ?string $name,
      public ?string $owner_name,
      public ?string $card_number,
      public ?string $due_date,
      public ?string $ccv
    ) {}
  }

  class CreateOrderDto {
    public function __construct(
      public int $total,
      public array $products,
      public CreateOrderPersonalDto $personal,
      public CreateOrderPaymentDto $payment,
      public CreateOrderAddressDto $address,
    ) {}
  }

  class GetOrderProductDto {
    public function __construct(
      public GetProductDto $product,
      public int $qnt,
      public ?float $rating = null
    ) {}
  }
  class GetOrderDto {
    public string $tracking_code;

    public function __construct(
      public int $id,
      public int $customer_id,
      public DateTime|string $ordered_at,
      public ?GetAddressDto $address = null,
      public ?GetOrderPaymentDto $payment = null,
      public array $products,
      public ?array $tracking = [],
      public ?bool $received = false
    ) {
      $tracking_code = strval($id) . strval($customer_id);
    }
  }
  class GetOrderToControlDto {
    public function __construct(
      public int $id,
      public int $customer_id,
      public Datetime $ordered_at,
      public GetAddressDto $address,
      public array $products,
    ) {}
  }

?>