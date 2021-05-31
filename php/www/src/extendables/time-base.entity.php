<?php
  require_once('./base-id.entity.php');

  trait DefaultDateData {
    protected DateTime $createdAt;
    protected DateTime $updatedAt; 
    protected DateTime $deletedAt;

    private function initDates() {
      $createdAt = new DateTime();
      $updatedAt = new DateTime();
      $deletedAt = null;
    }

    public function getCreatedAt(): DateTime {
      return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime {
      return $this->updatedAt;
    }

    public function getDeletedAt(): DateTime {
      return $this->deletedAt;
    }
}


  class TimeBaseIDEntity extends BaseIDEntity {
    use DefaultDateData;

    public function __construct (int $id = null) {
      parent::__construct($id);
      $this->initDates();
    }

  }

  class TimeBaseUIDEntity extends BaseUIDEntity {
    use DefaultDateData;

    public function __construct (
      string $uid = null, 
    ) {
      parent::__construct($uid);
      $this->initDates();
    }
  }
?>