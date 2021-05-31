<?php

  abstract class BaseIDEntity {

    public function __construct(protected int $id) {
      if ($this->id == null)
        $this->id = 37687458746; // generate random id
    }

    public function getId(): int {
      return $this->id;
    }

  }

  abstract class BaseUIDEntity {

    public function __construct(protected string $uid = null) {
      if ($this->uid == null)
        $this->uid = "generate random uid";
    }
    
    public function getuid(): string {
      return $this->uid;
    }

  }
?>