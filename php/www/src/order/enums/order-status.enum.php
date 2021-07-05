<?php

  class OrderStatus {
    public static int $PREPARING = 0;
    public static int $CHECKING = 1;
    public static int $TODELIVER = 2;
    public static int $DELIVERED = 3;


    public static function intToStr(int $value): string {
      switch($value) {
        case OrderStatus::$PREPARING:
          return "preparing";
        case OrderStatus::$CHECKING:
          return "checking";
        case OrderStatus::$TODELIVER:
          return "todeliver";
        case OrderStatus::$DELIVERED:
          return "delivered";
        default:
          return "";
      }

    }




  }



?>