<?php

  class PaymentMethod {
    public static int $CREDIT_CARD = 1;
    public static int $CASH = 0;

    public static function intToStr(int $value) {
      switch($value) {
        case 0:
          return "cash";
        case 1:
          return "credit card";
        default:
          throw new InvalidArgumentException('Invalid value');
      }
    }

    public static function strToInt(int $value) {
      switch($value) {
        case "cash":
          return 0;
        case "credit card":
          return 1;
        default:
          throw new InvalidArgumentException('Invalid value');
      }
    }
  }


?>