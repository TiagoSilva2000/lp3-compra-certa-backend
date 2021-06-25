<?php
  require_once (__DIR__ . '/../../user/dtos/user.dtos.php');

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

  class GetAuthResponse {
    public function __construct(
      public GetUserDto $user,
      public GetTokenDto $token
    ) {}
  }

?>