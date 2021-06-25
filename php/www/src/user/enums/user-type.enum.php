<?php

  class UserType {
    public static int $CUSTOMER = 0;
    public static int $ADMIN = 1;
    public static int $EMPLOYEE = 2;

    public static function intToStr(int $value) {
      switch ($value) {
        case 0: return "customer";
        case 1: return "admin";
        case 2: return "employee";
        default:
          throw new \InvalidArgumentException("invalid user type");
      }

    }

    public static function strToInt(string $value) {
      switch($value) {
        case "customer": return 0;
        case "admin": return 1;
        case "employee": return 2;
        default:
        throw new \InvalidArgumentException("invalid user type");
      }
    }
  }




?>