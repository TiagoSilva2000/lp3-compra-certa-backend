<?php
  use Dotenv\Dotenv;

  $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../../');
  $dotenv->load();

  class Connection {
    public static PDO $conn;

    public static function connect(): void {
      $servername = "$_ENV[DB_HOST]:$_ENV[DB_PORT]"; 
      $username = $_ENV['DB_USER'];
      $password = $_ENV['DB_PASSWORD'];
      $dbname = $_ENV['DB_NAME'];

      try {
         Connection::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
         Connection::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
       echo "Could not connect: " . $e->getmessage();
     }
  }


    // public static function connect (): void {
    //   try {
    //     Connection::$conn = mysqli_connect($_ENV['DB_HOST'], 
    //                                       $_ENV['DB_USER'], 
    //                                       $_ENV['DB_PASSWORD'], 
    //                                       $_ENV['DB_NAME'], 
    //                                       $_ENV['DB_PORT']);
    //     echo "Database connected successfully at port " . $_ENV['DB_PORT'];
    //   } catch (Exception $e) {
    //     die('Could not connect: ' . mysqli_error(Connection::$conn));
    //   }      
    // }

  }


?>