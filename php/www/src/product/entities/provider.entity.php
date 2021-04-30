<?php
  require_once('../../extendables/time-base.entity.php');


  class Provider extends TimeBaseIDEntity {

    public function __construct (
      private string $name,
      private int $stock,
    ) {}


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
       * Get the value of stock
       */
      public function getStock()
      {
            return $this->stock;
      }

      /**
       * Set the value of stock
       */
      public function setStock($stock) : self
      {
            $this->stock = $stock;

            return $this;
      }
  }

?>