<?php

  class GetProductDto {

    public function __construct (
      public int $id,
      public string $name, 
      public float $rating,
      public string $type,
      public string $description,
      public int $stock,
      public array $categories,
      public int $providerId,
      public array $medias = [],
      public int $soldQnt = 0,
      // public array $priceHistory,
      // public PriceHistory $activePrice,
      // public Media $mainMedia
    ) {}
  }

  class GetProductToHomeDto {
    public function __construct (
      public int $id,
      public string $name, 
      public float $rating,
      public string $type,
      public GetMediaDto $media,
      public GetPriceDto $price,
    ) {}

  }

  class GetMediaDto {

    public function __construct (
      public string $path,
      public bool $default
    ) {}
  }
  class GetPriceDto {

    public function __construct (
      public int $active_price,
      public int $divided_max,
      public int $payment_discount,
    ) {}
  }


?>