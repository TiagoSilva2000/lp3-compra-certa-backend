<?php
  require_once('../../extendables/time-base.entity.php');

  class OrderTracking extends TimeBaseUIDEntity {

    public function __construct (
      private int $orderId,
      private string $placeZipcode,
      private string $order_status,
      private ?DateTime $enter_time = null,
    ) {
      parent::__construct();
    }


      /**
       * Get the value of enter_time
       */
      public function getEnterTime()
      {
            return $this->enter_time;
      }

      /**
       * Set the value of enter_time
       */
      public function setEnterTime($enter_time) : self
      {
            $this->enter_time = $enter_time;

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
      public function setOrderStatus($order_status) : self
      {
            $this->order_status = $order_status;

            return $this;
      }
  }



?>