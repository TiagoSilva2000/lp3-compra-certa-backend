<?php
  require_once('../entities/user.entity.php');
  require_once('../services/user.service.php');

  class UserController {

    public static function create(): User {
      return UserService::create();
    }

    public static function read(): User {
      return UserService::read();
    }

    public static function update(): User {
      return UserService::update();

    }
    
    public static function delete(): void {
      UserService::delete();
    }
  }

?>