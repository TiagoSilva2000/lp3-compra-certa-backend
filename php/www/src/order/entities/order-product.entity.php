<?php

  class OrderProduct {

    public function __construct(
      private Product $product,
      private int $qnt
    )
    {}
      /**
       * Get the value of product
       */ 
      public function getProduct()
      {
            return $this->product;
      }

      /**
       * Set the value of product
       *
       * @return  self
       */ 
      public function setProduct($product)
      {
            $this->product = $product;

            return $this;
      }

      /**
       * Get the value of qnt
       */ 
      public function getQnt()
      {
            return $this->qnt;
      }

      /**
       * Set the value of qnt
       *
       * @return  self
       */ 
      public function setQnt($qnt)
      {
            $this->qnt = $qnt;

            return $this;
      }
  }

?>