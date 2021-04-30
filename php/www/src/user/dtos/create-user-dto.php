<?php

  class CreateUserDto {
    
    public function __construct(
      public string $email,
      public string $first_name,
      public string $last_name,
      public string $password,
      public string $phone,
      public string $cpf,
    ) {}

  }


?>