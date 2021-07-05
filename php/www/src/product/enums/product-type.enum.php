<?php

  class EProductType {
    public static $INFORMATIC = 1;
    public static $ELETRODOMESTIC = 2;
    public static $BOOK = 3;
    public static $HOUSESTUFF = 4;
    public static $MOBILE = 5;
    public static $TVANDVIDEO = 6;


    public static function intToStr(int $value) {
      switch ($value) {
        case self::$INFORMATIC:
          return "informatica";
        case self::$ELETRODOMESTIC:
          return "eletrodomestico";
        case self::$BOOK:
          return "livro";
        case self::$HOUSESTUFF:
          return "cama, mesa e banho";
        case self::$MOBILE:
          return "movel";
        case self::$TVANDVIDEO:
          return "tv e video";
      }
    }

    public static function strToInt(string|null $value):int|null {
      switch($value) {
        case "informatica":
          return self::$INFORMATIC;
        case "eletrodomestico":
          return self::$ELETRODOMESTIC;
        case "livro":
          return self::$BOOK;
        case "cama, mesa e banho":
          return self::$HOUSESTUFF;
        case "movel":
          return self::$MOBILE;
        case "tv e video":
          return self::$TVANDVIDEO;
        default:
          return null;
      }
    }
  }




?>