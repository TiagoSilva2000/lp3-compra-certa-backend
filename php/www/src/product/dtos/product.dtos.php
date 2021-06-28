<?php

  class CreateProductPriceDto {
    public function __construct(
      public int $value,
      public int $divided_max,
      public int $payment_discount
    ) {}
  }

  class CreateProductMediaDto {
    public function __construct (
      public string $path,
      public string $ext,
      public ?bool $main = false,
    ) {}
  }


  class CreateProductDto {

    public function __construct (
      public string $name,
      public string $description,
      public int $stock,
      public int $provider_id,
      public int $product_type_id,
      public CreateProductPriceDto $price,
      //public array $medias
    )
    {}
  }

  class GetMediaDto {
    public function __construct(
      public ?string $path = null,
      public ?string $ext = null,
      public ?bool $main = null,
    ) {}
  }

  class GetPriceDto {
    public function __construct (
      public int $value,
      public int $divided_max,
      public int $payment_discount,
      public bool $active
    ) {}
  }


  class GetProductDto {

    public function __construct (
      public int $id,
      public string $name, 
      public float $rating,
      public string $type,
      public string $description,
      public int $stock,
      public int $provider_id,
      public int $sold_qnt = 0,
      public GetPriceDto $active_price,
      public GetMediaDto $main_media
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

?>