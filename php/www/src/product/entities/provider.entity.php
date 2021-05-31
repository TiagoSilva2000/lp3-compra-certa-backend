<?php
  require_once('../../extendables/time-base.entity.php');


  class Provider extends TimeBaseIDEntity {

    public function __construct (
      private string $name,
      private array $products = []
    ) {
      parent::__construct();
    }

    public function pushProductMedia(string $pCode, Media $media) {
      $idx = array_search($pCode, $this->products);
      $product = $this->products[$idx];

      $product->pushProductMedia($media);
    }

    public function removeProductMedia(string $pCode, string $mediaCode) {
      $idx = array_search($pCode, $this->products);
      $product = $this->products[$idx];

      $product->removeMedia($mediaCode);
    }

    public function manageStock(string $pCode, int $modifier) {
      $idx = array_search($pCode, $this->products);
      $product = $this->products[$idx];

      $product->applyModifierInStock($modifier);
    }

    public function changePrice(string $pCode, int $value) {
      $idx = array_search($pCode, $this->products);
      $product = $this->products[$idx];

      $product->setPriceHistory(new PriceHistory($pCode, $value));
    }
    
    public function setMainMedia(string $pCode, string $mediaCode) {
      $idx = array_search($pCode, $this->products);
      $product = $this->products[$idx];

      $media = $product->getMedias()[0];
      $product->setMainMedia($media);
    }

    public function pushProduct (Product $product) {
      array_push($this->products, $product);
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
       * Get the value of products
       */ 
      public function getProducts()
      {
            return $this->products;
      }
  }
?>