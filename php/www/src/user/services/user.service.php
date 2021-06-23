<?php
  require (__DIR__ . '/../repositories/user.repository.php');
  require (__DIR__ . '/../dtos/user-dtos.php');

  class UserService {

    public static function create(CreateUserDto $createUserDto): GetUserDto {

      return UserRepository::createUser($createUserDto);
    }

    public static function read(int $id): GetUserDto|null {

      return UserRepository::read($id);
    }

    public static function update(int $id, UpdateUserDto $update): GetUserDto|null {
      return UserRepository::update($id, $update);
    }

    public static function delete(int $id): GetUserDto|null {
      return UserRepository::delete($id);
    }
    public static function recover(int $id): GetUserDto|null {
      return UserRepository::recover($id);
    }
  }

?>