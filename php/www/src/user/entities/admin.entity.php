<?php
  require_once('./user.entity.php');

  class Admin {
    private User $user;
    
    public function __construct(private string $userUid, private DateTime $expireAt)
    {}
    
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