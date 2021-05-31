<?php
  require_once('../../extendables/time-base.entity.php');


  class Product extends TimeBaseUIDEntity {
    private array $priceHistory;
    private Media $mainMedia;

    public function __construct (
      private string $name, 
      private float $rating,
      private string $description,
      private int $stock,
      private string $type,
      private array $categories,
      private PriceHistory $activePrice,
      private int $providerId,
      private array $medias = [],
      private int $soldQnt = 0,
    ) {
      $this->priceHistory = [$activePrice];
      if (count($medias) > 0)
        $this->mainMedia = $medias[0];
    }


    public function applyModifierInStock(int $modifier) {
      $tmp = $this->stock;
      $tmp += $modifier;
      if ($tmp < 0)
        throw new Error("estoque nao pode ser menor do que zero");

      $this->stock = $tmp;
    }

    public function pushMedia(Media $media) {
      array_push($this->medias, $media);
    }

    public function removeMedia(string $code) {
      foreach($this->medias as &$media) {
        if ($media->getuid() == $code) {
          unset($media);
          break;
        }
      }
    }

    public function pushCategory(string $cat) {
      array_push($this->categories, $cat);
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
       *
       * @return  self
       */ 
      public function setName($name)
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
       *
       * @return  self
       */ 
      public function setRating($rating)
      {
            $this->rating = $rating;

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
       *
       * @return  self
       */ 
      public function setDescription($description)
      {
            $this->description = $description;

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
       *
       * @return  self
       */ 
      public function setStock($stock)
      {
            $this->stock = $stock;

            return $this;
      }

      /**
       * Get the value of type
       */ 
      public function getType()
      {
            return $this->type;
      }

      /**
       * Set the value of type
       *
       * @return  self
       */ 
      public function setType($type)
      {
            $this->type = $type;

            return $this;
      }

      /**
       * Get the value of categories
       */ 
      public function getCategories()
      {
            return $this->categories;
      }

      /**
       * Get the value of activePrice
       */ 
      public function getActivePrice()
      {
            return $this->activePrice;
      }

      /**
       * Set the value of activePrice
       *
       * @return  self
       */ 
      public function setActivePrice($activePrice)
      {
            $this->activePrice = $activePrice;

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
       *
       * @return  self
       */ 
      public function setProviderId($providerId)
      {
            $this->providerId = $providerId;

            return $this;
      }

      /**
       * Get the value of soldQnt
       */ 
      public function getSoldQnt()
      {
            return $this->soldQnt;
      }

      /**
       * Set the value of soldQnt
       *
       * @return  self
       */ 
      public function setSoldQnt($soldQnt)
      {
            $this->soldQnt = $soldQnt;

            return $this;
      }

      /**
       * Get the value of medias
       */ 
      public function getMedias()
      {
            return $this->medias;
      }
  }



?>