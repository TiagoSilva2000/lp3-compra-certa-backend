<?php
  require_once('../../extendables/time-base.entity.php');


  class Payment extends TimeBaseUIDEntity {

    public function __construct (
      private PaymentOption $paymentOption,
      private string $paymentStatus,
      private float $total,
    ) {
      parent::__construct();
    }

    
      /**
       * Get the value of paymentOptionsId
       */
      public function getPaymentOptionsId()
      {
            return $this->paymentOptionsId;
      }

      /**
       * Set the value of paymentOptionsId
       */
      public function setPaymentOptionsId($paymentOptionsId) : self
      {
            $this->paymentOptionsId = $paymentOptionsId;

            return $this;
      }

      /**
       * Get the value of paymentStatusId
       */
      public function getPaymentStatusId()
      {
            return $this->paymentStatusId;
      }

      /**
       * Set the value of paymentStatusId
       */
      public function setPaymentStatusId($paymentStatusId) : self
      {
            $this->paymentStatusId = $paymentStatusId;

            return $this;
      }

      /**
       * Get the value of total
       */
      public function getTotal()
      {
            return $this->total;
      }

      /**
       * Set the value of total
       */
      public function setTotal($total) : self
      {
            $this->total = $total;

            return $this;
      }
  }


?>