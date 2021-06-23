<?
  require_once('../entities/user.entity.php');

  class UserRepository {

    public static function createUser(): User {
      return new User('aaaa',
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }
    
    public static function getUser(): User {
      return new User('aaaa',
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }

    public static function updateUser(): User {
      return new User('aaaa',
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }

    public static function deleteUser(): void {}

  }

?>