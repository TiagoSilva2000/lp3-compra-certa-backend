<?php
  require_once (__DIR__ . '/../../utils/ResponseMessage.php');
  require_once (__DIR__ . '/../repositories/wishlist.repository.php');

  class WishlistService {

    public static function list(int $userId): array {

      return WishlistRepository::list($userId);
    }

    public static function add(int $productId, int $userId): ResponseMessage {
      $result = WishlistRepository::add($productId, $userId);

      return $result;
    }

    public static function remove(int $productId, int $userId): ResponseMessage {
      $result = WishlistRepository::remove($productId, $userId);

      return $result;
    }
  }


?>