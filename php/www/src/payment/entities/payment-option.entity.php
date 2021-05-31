<?php
  require_once('../../extendables/base.entity.php');

  class PaymentOption extends BaseUIDEntity {

    public function __construct (
      private string $name,
      private int $customerId,
    ) {
      parent::__construct();
    }

      /**
       * Get the value of name
       */
      public function getName()
      {
            return $this->name;
      }

      /**
       * Set the value of name
       */
      public function setName($name) : self
      {
            $this->name = $name;

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
  }


?>