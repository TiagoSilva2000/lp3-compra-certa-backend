<?php

  class OrderAssigned {

    public function __construct(
      private string $empId,
      private Order $order,
      private string $orderStatus,
      private DateTime $at
    ) {}

    public function getEmpId(): string {
      return $this->empId;
    }
    public function setEmpId(string $empId) {
      $this->empId = $empId;
    }

    public function getOrder(): Order {
      return $this->order;
    }

    public function getStatus(): string {
      return $this->orderStatus;
    }

    public function setStatus(string $status) {
      $this->orderStatus = $status;
    }

    public function setAt(DateTime $at) {
      $this->at = $at;
    }

    public function getAt(): DateTime {
      return $this->at;
    }
  }

?>