<?php
  require_once('../../extendables/base.entity.php');

  class Session extends BaseUIDEntity {

    public function __construct (
      private string $token,
      private string $device,
      private bool $isTrusted,
      private bool $active
    ) {}

      /**
       * Get the value of token
       */
      public function getToken()
      {
            return $this->token;
      }

      /**
       * Set the value of token
       */
      public function setToken($token) : self
      {
            $this->token = $token;

            return $this;
      }

      /**
       * Get the value of device
       */
      public function getDevice()
      {
            return $this->device;
      }

      /**
       * Set the value of device
       */
      public function setDevice($device) : self
      {
            $this->device = $device;

            return $this;
      }

      /**
       * Get the value of isTrusted
       */
      public function getIsTrusted()
      {
            return $this->isTrusted;
      }

      /**
       * Set the value of isTrusted
       */
      public function setIsTrusted($isTrusted) : self
      {
            $this->isTrusted = $isTrusted;

            return $this;
      }
  }


?>