<?php
  require_once('./user.entity.php');

  class Admin extends User {
    public function __construct(
      string $email,
      string $first_name,
      string $last_name,
      string $password,
      string $phone,
      string $cpf,
      private DateTime $expireAt = null
    ) {
      parent::__construct(
        $email, 
        $first_name, 
        $last_name, 
        $password, 
        $phone, 
        $cpf);
      parent::setAccount(new Account(parent::getuid(), "admin"));
    }
    
    public function hire(User $user): Employee {

      return Employee::buildFromUser($user, new DateTime());
    }

    public function dismiss(Employee $employee): bool {
      $employee->setFiredAt(new DateTime());

      return true;
    } 

    public function getUser(): User {
      return $this->user;
    }

    public function getUserUid(): string {
      return $this->userUid;
    }

    public function getExpireAt(): DateTime {
      return $this->expireAt;
    }

    public function setExpireAt(DateTime $expireAt): void {
      $this->user_uid = $expireAt;
    }

  }

?>