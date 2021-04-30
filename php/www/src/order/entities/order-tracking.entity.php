<?php
  require_once('../../extendables/time-base.entity.php');

  class OrderTracking extends TimeBaseUIDEntity {
    private DateTime $orderedAt;

    public function __construct (
      private DateTime $enterTime,
      private string $placeZipcode,
      private int $orderId,
      private int $orderStatusID,
    ) {
      $this->orderedAt = new DateTime();
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
      public function getOrderStatusID()
      {
            return $this->orderStatusID;
      }

      /**
       * Set the value of orderStatusID
       */
      public function setOrderStatusID($orderStatusID) : self
      {
            $this->orderStatusID = $orderStatusID;

            return $this;
      }
  }



?>