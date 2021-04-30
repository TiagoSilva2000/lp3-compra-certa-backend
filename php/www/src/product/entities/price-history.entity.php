<?php
  require_once('../../extendables/time-base.entity.php');

  class PriceHistory extends TimeBaseUIDEntity {

    public function __construct(
      private int $productId,
      private int $pricingRuleId,
      private float $value,
      private DateTime $expiredAt, 
    ) {}


      /**
       * Get the value of productId
       */
      public function getProductId()
      {
            return $this->productId;
      }

      /**
       * Set the value of productId
       */
      public function setProductId($productId) : self
      {
            $this->productId = $productId;

            return $this;
      }

      /**
       * Get the value of pricingRuleId
       */
      public function getPricingRuleId()
      {
            return $this->pricingRuleId;
      }

      /**
       * Set the value of pricingRuleId
       */
      public function setPricingRuleId($pricingRuleId) : self
      {
            $this->pricingRuleId = $pricingRuleId;

            return $this;
      }

      /**
       * Get the value of value
       */
      public function getValue()
      {
            return $this->value;
      }

      /**
       * Set the value of value
       */
      public function setValue($value) : self
      {
            $this->value = $value;

            return $this;
      }

      /**
       * Get the value of expiredAt
       */
      public function getExpiredAt()
      {
            return $this->expiredAt;
      }

      /**
       * Set the value of expiredAt
       */
      public function setExpiredAt($expiredAt) : self
      {
            $this->expiredAt = $expiredAt;

            return $this;
      }
  }



  


?>