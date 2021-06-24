<?php

  class GetEmployeeOrderDto {

    public function __construct(
      public int $id,
      public int $employeeId,
      public int $orderId,
      public string $status,
      public DateTime $at,
    ) {}
  }


?>