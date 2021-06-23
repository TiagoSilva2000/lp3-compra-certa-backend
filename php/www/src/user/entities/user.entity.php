<?php
  require (__DIR__ . "/../../extendables/time-base.entity.php");
  // require_once('../../extendables/time-base.entityphp');

  class User extends TimeBaseIDEntity {
    protected Account $account;

    public function __construct(
      protected string $email,
      protected string $first_name,
      protected string $last_name,
      protected string $password,
      protected string $phone,
      protected string $cpf,
      protected int $user_type
    ) {
      parent::__construct();
    }

    public function resetPassword(string $old, string $new, string $newConfirm) {
      if ($new != $newConfirm) {
        throw new Error("passwords do not match");
      }
      if ($this->password != $old) {
        throw new Error("this is not the old password");
      }
      
      $this->password = $new;
    }

    public function getEmail(): string {
      return $this->email;
    }

    public function getFirstName(): string {
      return $this->first_name;
    }

    public function getLastName(): string {
      return $this->last_name;
    }

    public function getPhone(): string {
      return $this->phone;
    }

    public function getCPF(): string {
      return $this->cpf;
    }

    public function setEmail(string $email): void {
      $this->email = $email;
    }

    public function setFirstName(string $first_name): void {
      $this->first_name = $first_name;
    }

    public function setLastName(string $last_name): void {
      $this->last_name = $last_name;
    }

    public function setPassword(string $password): void {
      $this->password = $password;
    }

    public function setPhone(string $phone): void {
      $this->phone = $phone;
    }

    public function setCPF(string $cpf): void {
      $this->cpf = $cpf;
    }

    public function getFullName(): string {
      return $this->first_name . $this->last_name;
    }


    /**
     * Get the value of account
     */ 
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @return  self
     */ 
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }
  }

?>