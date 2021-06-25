<?php

use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

require_once (__DIR__ . '/../repositories/user.repository.php');
require_once (__DIR__ . '/../repositories/customer.repository.php');
  require_once (__DIR__ . '/../dtos/user.dtos.php');

  class UserService {

    public static function create(CreateUserDto $createUserDto): GetUserDto {
      $user = UserRepository::createUser($createUserDto);

      switch($user->user_type) {
        case UserType::$CUSTOMER:
          $user->customer = CustomerRepository::createCustomer($user->id);
        case UserType::$ADMIN:
        case UserType::$EMPLOYEE:
        default:
          throw new InvalidArgumentException("incorret user type", 400);
      }

      return $user;
    }

    public static function checkUserCredentials(string $email, string $password): GetUserDto {

      $user = UserRepository::readByEmail($email);
      if ($user == null) {
        // throw new HttpNotFoundException($request, "user not found");
      } 
      if ($user->password != $password) {
        // throw new HttpBadRequestException($request, "authentication failed");
      }

      return $user;
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