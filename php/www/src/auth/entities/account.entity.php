<?php
  require_once('../../extendables/base.entity.php');

  class Account extends BaseUIDEntity {

    public function __construct (
      private string $userId,
      private int $accountTypeId,
    ) {}

      /**
       * Get the value of userId
       */
      public function getUserId()
      {
            return $this->userId;
      }

      /**
       * Set the value of userId
       */
      public function setUserId($userId) : self
      {
            $this->userId = $userId;

            return $this;
      }

      /**
       * Get the value of accountTypeId
       */
      public function getAccountTypeId()
      {
            return $this->accountTypeId;
      }

      /**
       * Set the value of accountTypeId
       */
      public function setAccountTypeId($accountTypeId) : self
      {
            $this->accountTypeId = $accountTypeId;

            return $this;
      }
  }
?>