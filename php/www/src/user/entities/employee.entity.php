<?php
  require_once('./user.entity.php');

  class Employee {
    private User $user;

    public function __construct (
      private string $userUid, 
      private int $totalRequests, 
      private DateTime $hiredAt, 
      private DateTime $firedAt
    ) {}

    public function getUser(): User {
      return $this->user;
    }

    public function getUserUid(): string {
      return $this->userUid;
    }

    public function getTotalRequests(): int {
      return $this->totalRequests;
    }

    public function changeTotalRequests(int $amount): void {
      $this->totalRequests += $amount;
    }

    public function getHiredAt(): DateTime {
      return $this->hiredAt;
    }

    public function getFiredAt(): DateTime {
      return $this->firedAt;
    }

    public function setFiredAt(DateTime $firedAt): void {
      $this->firedAt =  $firedAt;
    }
  }

?>