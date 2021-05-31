<?php
  require_once('../../extendables/base.entity.php');

  class Account extends BaseUIDEntity {
    private array $sessions;

    public function __construct (
      private string $accountType,
    ) {
      $this->sessions = [];
    }
  
    public function addSession(Session $session) {
      array_push($this->sessions, $session);
    }

    public function deleteSession(string $sessionCode) {
      $len = count($this->sessions);
      for ($i = 0; $i < $len; $i++) {
        if ($this->sessions[$i]->getuid() == $sessionCode) {
          unset($this->sessions[$i]);
          break;
        }
      }
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