<?php

  require_once('../../extendables/time-base.entity.php');

  class RegisteredAccount extends TimeBaseIDEntity {

    public function __construct (
      private string $email,
      private string $name,
      private bool $allowed,
    ) {}


      /**
       * Get the value of email
       */
      public function getEmail()
      {
            return $this->email;
      }

      /**
       * Get the value of name
       */
      public function getName()
      {
            return $this->name;
      }

      /**
       * Get the value of allowed
       */
      public function getAllowed()
      {
            return $this->allowed;
      }


      /**
       * Set the value of allowed
       */
      public function setAllowed($allowed) : self
      {
            $this->allowed = $allowed;

            return $this;
      }
  }


?>