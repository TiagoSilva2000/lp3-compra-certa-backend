<?php
  require_once('./user.entity.php');

  class Employee extends User {
    private User $user;
    private int $totalRequests;
    private array $ordersAssigned;
    private Order $orderCurrentlyAssigned;

    public function __construct (
      private string $email,
      private string $first_name,
      private string $last_name,
      private string $password,
      private string $phone,
      private string $cpf,
      private DateTime $hiredAt, 
      private DateTime $firedAt = null
    ) {
      parent::__construct(
        $email,
        $first_name, 
        $last_name, 
        $password, 
        $phone, 
        $cpf);
      parent::setAccount(new Account(parent::getuid(), "employee"));
      $this->totalRequests = 0;
      $this->ordersAssigned = [];
      $this->orderCurrentlyAssigned = null;
    }

    public static function buildFromUser(User $user, DateTime $hiredAt): Employee {
      return new Employee(
        $user->getEmail(),
        $user->getFirstName(),
        $user->getLastName(),
        $user->getLastName(),
        $user->getPhone(),
        $user->getCPF(),
        $hiredAt
      );
    }

    public function changeOrderState(Order $order, string $status) {
      $order->setStatus($status);
      if ($this->orderCurrentlyAssigned == null)
        $this->orderCurrentlyAssigned = $order;
    }

    public function unassignOrder(): bool {
      $this->orderCurrentlyAssigned = null;

      return true;
    }

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