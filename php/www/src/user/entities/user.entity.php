<?php
  require_once('../../extendables/time-base.entity.php');


  class User extends TimeBaseUIDEntity {

    public function __construct(
      $uid, 
      $createdAt, 
      $updatedAt, 
      $deletedAt,
      private string $email,
      private string $first_name,
      private string $last_name,
      private string $password,
      private string $phone,
      private string $cpf,
    ) {
      parent::__construct($uid, $createdAt, $updatedAt, $deletedAt);
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

    // public function getPassword(): string {
    //   return $this->password;
    // }

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

  }

?>