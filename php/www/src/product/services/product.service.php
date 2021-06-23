<?php
  require_once (__DIR__ . '/../repositories/product.repository.php');

  class ProductService {

    public static function home(): array {
      return ProductRepository::home(); 
    }

    public static function list(): array {
      return ProductRepository::list();
    }

    public static function read(int $id): GetProductDto|null {
      return ProductRepository::read($id);
    }

  }
?>