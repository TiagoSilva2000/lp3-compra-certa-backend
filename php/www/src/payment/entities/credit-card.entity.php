<?php
  require_once('../../extendables/base.entity.php');

  class CreditCard extends BaseUIDEntity {

    public function __construct (
      private int $customerId,
      private int $paymentOptionId,
      private string $ownerName,
      private string $lastDigits,
      private string $cardName,
      private bool $isDefault,
    ) {}

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
       * Get the value of paymentOptionId
       */
      public function getPaymentOptionId()
      {
            return $this->paymentOptionId;
      }

      /**
       * Set the value of paymentOptionId
       */
      public function setPaymentOptionId($paymentOptionId) : self
      {
            $this->paymentOptionId = $paymentOptionId;

            return $this;
      }

      /**
       * Get the value of ownerName
       */
      public function getOwnerName()
      {
            return $this->ownerName;
      }

      /**
       * Set the value of ownerName
       */
      public function setOwnerName($ownerName) : self
      {
            $this->ownerName = $ownerName;

            return $this;
      }

      /**
       * Get the value of lastDigits
       */
      public function getLastDigits()
      {
            return $this->lastDigits;
      }

      /**
       * Set the value of lastDigits
       */
      public function setLastDigits($lastDigits) : self
      {
            $this->lastDigits = $lastDigits;

            return $this;
      }

      /**
       * Get the value of cardName
       */
      public function getCardName()
      {
            return $this->cardName;
      }

      /**
       * Set the value of cardName
       */
      public function setCardName($cardName) : self
      {
            $this->cardName = $cardName;

            return $this;
      }

      /**
       * Get the value of isDefault
       */
      public function getIsDefault()
      {
            return $this->isDefault;
      }

      /**
       * Set the value of isDefault
       */
      public function setIsDefault($isDefault) : self
      {
            $this->isDefault = $isDefault;

            return $this;
      }
  }


?>