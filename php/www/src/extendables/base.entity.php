<?php

  abstract class BaseIDEntity {

    public function __construct(protected int $id) {}

    public function getId(): int {
      return $this->id;
    }

  }

  abstract class BaseUIDEntity {

    public function __construct(protected string $uid) {}
    
    public function getuid(): string {
      return $this->uid;
    }

  }
?>