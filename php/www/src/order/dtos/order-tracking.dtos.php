<?php

  class CreateOrderTrackingDto {
    public function __construct(
      public DateTime $enterTime,
      public string $orderStatus,
      public string $zipcode,
    ) {}
  }

  class GetOrderTrackingDto {
    public function __construct(
      public int $id,
      public int $order_id,
      public DateTime|string $enterTime,
      public string $orderStatus,
      public string $zipcode,
    ) {}
  }


?>