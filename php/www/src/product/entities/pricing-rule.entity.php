<?php
  require_once('../../extendables/base.entity.php');

  class PricingRule extends BaseIDEntity {

    public function __construct(
      private int $divisionMax,
      private float $paymentDiscount,
    ) {}


      /**
       * Get the value of divisionMax
       */
      public function getDivisionMax()
      {
            return $this->divisionMax;
      }

      /**
       * Set the value of divisionMax
       */
      public function setDivisionMax($divisionMax) : self
      {
            $this->divisionMax = $divisionMax;

            return $this;
      }

      /**
       * Get the value of paymentDiscount
       */
      public function getPaymentDiscount()
      {
            return $this->paymentDiscount;
      }

      /**
       * Set the value of paymentDiscount
       */
      public function setPaymentDiscount($paymentDiscount) : self
      {
            $this->paymentDiscount = $paymentDiscount;

            return $this;
      }
  }



  


?>