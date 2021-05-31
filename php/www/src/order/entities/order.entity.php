<?php
  require_once('../../extendables/time-base.entity.php');

  class Order extends TimeBaseUIDEntity {
    

    public function __construct (
      private Payment $payment,
      private array $products,
      private string $customerId,
      private Address $address,
      private string $status = "CREATED",
      private array $trackingPoints = [],
      private DateTime $orderedAt = new DateTime(),
      private float $rating = null,
    ) {
      parent::__construct();
    }

    public function getStatus(): string {
      return $this->status;
    }

    public function setStatus(string $status) {
      $this->status = $status;
    }

    public function setRating(float $rating) {
      $this->rating = $rating;
    }

    public function getRating() {
      return $this->rating;
    }

    public function pushTrackingPoint(OrderTracking $tracking) {
      array_push($this->trackingPoints, $tracking);
    }

      /**
       * Get the value of payment
       */ 
      public function getPayment()
      {
            return $this->payment;
      }

      /**
       * Set the value of payment
       *
       * @return  self
       */ 
      public function setPayment($payment)
      {
            $this->payment = $payment;

            return $this;
      }

      /**
       * Get the value of customerId
       */ 
      public function getCustomerId()
      {
            return $this->customerId;
      }

      /**
       * Set the value of customerId
       *
       * @return  self
       */ 
      public function setCustomerId($customerId)
      {
            $this->customerId = $customerId;

            return $this;
      }

      /**
       * Get the value of address
       */ 
      public function getAddress()
      {
            return $this->address;
      }

      /**
       * Set the value of address
       *
       * @return  self
       */ 
      public function setAddress($address)
      {
            $this->address = $address;

            return $this;
      }

      /**
       * Get the value of orderedAt
       */ 
      public function getOrderedAt()
      {
            return $this->orderedAt;
      }
  }



?>