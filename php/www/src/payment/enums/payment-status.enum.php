<?php

  class PaymentStatus {
    public static int $PAID = 0;

    public static function intToStr(int $value) {
      switch ($value) {
        case 0:
          return "paid";
        default:
          throw new InvalidArgumentException('Invalid value');
      }
    }

    public static function strToInt(int $value) {
      switch ($value) {
        case "paid":
          return 0;
        default:
          throw new InvalidArgumentException('Invalid value');
      }
    }
  }



?>