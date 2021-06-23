<?php

  class CreateAddressDto {
    public function __construct(
			public string $cep,
			public string $street,
			public string $neighbour,
			public string $city,
			public string $state,
			public string $country,
			public string $house_id,
			public string $details,
			public string $owner_phone,
    ) {}
  }

  class GetAddressDto {
    
    public function __construct(
      public int $id,
      public int $user_id,
			public string $city,
			public string $state,
			public string $country,
			public string $cep,
			public string $street,
			public string $neighbour,
			public string $house_id,
			public string $details,
			public string $owner_phone,
    ) {}
  }

  class GetUpdatedAddressDto {
    
    public function __construct(
      public int $id,
			public string $city,
			public string $state,
			public string $country,
			public string $cep,
			public string $street,
			public string $neighbour,
			public string $house_id,
			public string $details,
			public string $owner_phone,
    ) {}
  }


?>