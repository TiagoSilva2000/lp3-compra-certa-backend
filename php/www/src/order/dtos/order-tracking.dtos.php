<?php

  class CreateOrderTrackingDto {
    public function __construct(
      public DateTime $enter_time,
      public string $order_status,
      public string $zipcode,
    ) {}
  }

  class GetOrderTrackingDto {
    public function __construct(
      public int $id,
      public int $order_id,
      public DateTime|string $enter_time,
      public string $order_status,
      public string $zipcode,
    ) {}
  }


?>