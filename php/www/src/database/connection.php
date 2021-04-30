<?php

  class Connection {
    private static $conn;


    public function connect (): PDO {
      $connStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", [

      ]);
      
      $pdo = new \PDO($connStr);
      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }

  }


?>