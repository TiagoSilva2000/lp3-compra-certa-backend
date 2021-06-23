<?php
  class UserType {
    public static string $ADMIN = "admin";
    public static string $CUSTOMER = "customer";
    public static string $EMPLOYEE = "employee";

    public static function strToInt(string $type): int {
      switch($type) {
        case "admin":
          return 0;
        case "customer":
          return 1;
        case "employee":
          return 2;
        default:
          throw new \InvalidArgumentException("invalid user type");
      }
    }

    public static function intToStr(int $type): string {
      switch($type) {
        case 0:
          return "admin";
        case 1:
          return "customer";
        case 2:
          return "employee";
        default:
          throw new \InvalidArgumentException("invalid user type");
      }
    }
  }
?>