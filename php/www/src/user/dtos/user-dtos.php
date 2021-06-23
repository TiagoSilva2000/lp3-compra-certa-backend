<?php

  class CreateUserDto {
    
    public function __construct(
      public string $email,
      public string $first_name,
      public string $last_name,
      public string $password,
      public string $phone,
      public string $cpf,
      public int $user_type
    ) {}

  }
  class GetUserDto {

    public function __construct(
      public int $id,
      public string $email,
      public string $first_name,
      public string $last_name,
      public string $password,
      public string $phone,
      public string $cpf,
      public int $user_type
    ) {}
  }
  class UpdateUserDto {

    public function __construct(
      public string $email,
      public string $first_name,
      public string $last_name,
      public string $phone,
      public string $cpf,
    ) {}
  }

?>