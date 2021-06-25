<?php

  class GetCustomerDto {
    public function __construct(
      public int $user_id,
      public int $total_spent,
      public int $total_bought
    ) {}
  }
?>