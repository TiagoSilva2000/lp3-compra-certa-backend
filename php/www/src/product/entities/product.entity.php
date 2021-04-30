<?php
  require_once('../../extendables/time-base.entity.php');


  class Product extends TimeBaseUIDEntity {

    public function __construct (
      private string $name, 
      private float $rating, 
      private int $sold_qnt,
      private int $providerId,
      private int $activePriceId, 
      private string $description
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
       * Get the value of rating
       */
      public function getRating()
      {
            return $this->rating;
      }

      /**
       * Set the value of rating
       */
      public function setRating($rating) : self
      {
            $this->rating = $rating;

            return $this;
      }

      /**
       * Get the value of sold_qnt
       */
      public function getSoldQnt()
      {
            return $this->sold_qnt;
      }

      /**
       * Set the value of sold_qnt
       */
      public function setSoldQnt($sold_qnt) : self
      {
            $this->sold_qnt = $sold_qnt;

            return $this;
      }

      /**
       * Get the value of providerId
       */
      public function getProviderId()
      {
            return $this->providerId;
      }

      /**
       * Set the value of providerId
       */
      public function setProviderId($providerId) : self
      {
            $this->providerId = $providerId;

            return $this;
      }

      /**
       * Get the value of activePriceId
       */
      public function getActivePriceId()
      {
            return $this->activePriceId;
      }

      /**
       * Set the value of activePriceId
       */
      public function setActivePriceId($activePriceId) : self
      {
            $this->activePriceId = $activePriceId;

            return $this;
      }

      /**
       * Get the value of description
       */
      public function getDescription()
      {
            return $this->description;
      }

      /**
       * Set the value of description
       */
      public function setDescription($description) : self
      {
            $this->description = $description;

            return $this;
      }
  }



?>