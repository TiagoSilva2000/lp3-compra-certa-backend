<?php

  class OrderAssigned {

    public function __construct(
      private string $empId,
      private Order $order,
      private string $order_status,
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
      return $this->order_status;
    }

    public function setStatus(string $status) {
      $this->order_status = $status;
    }

    public function setAt(DateTime $at) {
      $this->at = $at;
    }

    public function getAt(): DateTime {
      return $this->at;
    }
  }

?>