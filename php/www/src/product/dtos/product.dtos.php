<?php

  class GetProductDto {

    public function __construct (
      public int $id,
      public string $name, 
      public float $rating,
      public string $description,
      public int $stock,
      public string $type,
      public array $categories,
      public int $providerId,
      public array $medias = [],
      public int $soldQnt = 0,
      // public array $priceHistory,
      // public PriceHistory $activePrice,
      // public Media $mainMedia
    ) {}
  }


?>