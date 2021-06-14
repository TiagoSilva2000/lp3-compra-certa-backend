<?php

  class UserService {

    public static function create(): User {
      return new User('aaaa', 
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }

    public static function read(): User {
      return new User('aaaa',
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }

    public static function update(): User {
      return new User('aaaa',
      'mail@mail.com', 'tiago', 'moreira', 
      '1234', '6468746845', '9595965356');
    }

    public static function delete(): void {}
  }

?>