<?php
  require_once('./user.entity.php');


  class Customer {
    private User $user;

    public function __construct (
      private string $userUid,
      private float $totalSpent,
      private int $totalBought 
    ) {}

    public function getUser(): User {
      return $this->user;
    }

    public function getUserUid(): string {
      return $this->userUid;
    }

    public function getTotalSpent(): float {
      return $this->totalSpent;
    }

    public function changeTotalSpent(float $amount): float {
      return $this->totalSpent += $amount;
    }

    public function getTotalBought(): int {
      return $this->totalBought;
    }

    public function changeTotalBought(int $amount): int {
      return $this->totalBought += $amount;
    }

  }

?>