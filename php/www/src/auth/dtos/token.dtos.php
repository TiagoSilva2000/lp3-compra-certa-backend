<?php

  class GetTokenDto {

    public function __construct(
      public int $user_id,
      public string $token
    ) {}
  }

  class GetTokenPayload {

    public function __construct(
      public int $user_id,
      public string $user_role
    ) {}
  }

?>