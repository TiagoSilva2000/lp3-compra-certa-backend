<?
  require_once('../entities/admin.entity.php');

  class AdminRepository {

    public static function createAdmin(): Admin {
      return new Admin("asdasdsadsadad", new DateTime());
    }

    public static function getAdmin(): Admin {
      return new Admin("asdasdsadsadad", new DateTime());
    }

    public static function updateAdmin(): Admin {
      return new Admin("asdasdsadsadad", new DateTime());
    }

    public static function deleteAdmin(): void {}


  }

?>