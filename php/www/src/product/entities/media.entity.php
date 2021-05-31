<?php
  require_once('../../extendables/time-base.entity.php');

  class Media extends TimeBaseUIDEntity {

    public function __construct (
      private int $productId,
      private string $path,
      private string $ext,
      private bool $main
    ) {
      parent::__construct();
    }


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
       * Get the value of path
       */
      public function getPath()
      {
            return $this->path;
      }

      /**
       * Set the value of path
       */
      public function setPath($path) : self
      {
            $this->path = $path;

            return $this;
      }

      /**
       * Get the value of ext
       */
      public function getExt()
      {
            return $this->ext;
      }

      /**
       * Set the value of ext
       */
      public function setExt($ext) : self
      {
            $this->ext = $ext;

            return $this;
      }

      /**
       * Get the value of main
       */
      public function getMain()
      {
            return $this->main;
      }

      /**
       * Set the value of main
       */
      public function setMain($main) : self
      {
            $this->main = $main;

            return $this;
      }
  }
  


?>