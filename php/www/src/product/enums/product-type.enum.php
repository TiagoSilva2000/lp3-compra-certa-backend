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
          return "informática";
        case self::$ELETRODOMESTIC:
          return "eletrodoméstico";
        case self::$BOOK:
          return "livro";
        case self::$HOUSESTUFF:
          return "cama, mesa e banho";
        case self::$MOBILE:
          return "móvel";
        case self::$TVANDVIDEO:
          return "tv e vídeo";
      }
    }
  }




?>