<?php
  require_once('../../extendables/time-base.entity.php');

  class Order extends TimeBaseUIDEntity {
    private DateTime $orderedAt;

    public function __construct (
      private int $paymentId,
      private int $orderTrackingId,
      private int $customerId,
      private int $addressId,
    ) {
      $this->orderedAt = new DateTime();
    }


      /**
       * Get the value of paymentId
       */
      public function getPaymentId()
      {
            return $this->paymentId;
      }

      /**
       * Set the value of paymentId
       */
      public function setPaymentId($paymentId) : self
      {
            $this->paymentId = $paymentId;

            return $this;
      }

      /**
       * Get the value of orderTrackingId
       */
      public function getOrderTrackingId()
      {
            return $this->orderTrackingId;
      }

      /**
       * Set the value of orderTrackingId
       */
      public function setOrderTrackingId($orderTrackingId) : self
      {
            $this->orderTrackingId = $orderTrackingId;

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
       */
      public function setCustomerId($customerId) : self
      {
            $this->customerId = $customerId;

            return $this;
      }

      /**
       * Get the value of addressId
       */
      public function getAddressId()
      {
            return $this->addressId;
      }

      /**
       * Set the value of addressId
       */
      public function setAddressId($addressId) : self
      {
            $this->addressId = $addressId;

            return $this;
      }
  }



?>