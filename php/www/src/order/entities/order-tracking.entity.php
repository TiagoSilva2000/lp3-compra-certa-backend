<?php
  require_once('../../extendables/time-base.entity.php');

  class OrderTracking extends TimeBaseUIDEntity {

    public function __construct (
      private int $orderId,
      private string $placeZipcode,
      private string $orderStatus,
      private DateTime $enterTime = new DateTime(),
    ) {
      parent::__construct();
    }


      /**
       * Get the value of enterTime
       */
      public function getEnterTime()
      {
            return $this->enterTime;
      }

      /**
       * Set the value of enterTime
       */
      public function setEnterTime($enterTime) : self
      {
            $this->enterTime = $enterTime;

            return $this;
      }

      /**
       * Get the value of placeZipcode
       */
      public function getPlaceZipcode()
      {
            return $this->placeZipcode;
      }

      /**
       * Set the value of placeZipcode
       */
      public function setPlaceZipcode($placeZipcode) : self
      {
            $this->placeZipcode = $placeZipcode;

            return $this;
      }

      /**
       * Get the value of orderId
       */
      public function getOrderId()
      {
            return $this->orderId;
      }

      /**
       * Set the value of orderId
       */
      public function setOrderId($orderId) : self
      {
            $this->orderId = $orderId;

            return $this;
      }

      /**
       * Get the value of orderStatusID
       */
      public function getOrderStatus()
      {
            return $this->orderStatusID;
      }

      /**
       * Set the value of orderStatusID
       */
      public function setOrderStatus($orderStatus) : self
      {
            $this->orderStatus = $orderStatus;

            return $this;
      }
  }



?>