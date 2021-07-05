<?php
  require_once (__DIR__ . '/../repositories/product.repository.php');
  require_once (__DIR__ . '/../repositories/price-history.repository.php');
  require_once (__DIR__ . '/../repositories/media.repository.php');
  require_once (__DIR__ . '/../repositories/wishlist.repository.php');

  class ProductService {

    /**
     * @throws Exception
     */
    public static function createMany(array $createProductDtos): ResponseMessage {
      try {
        foreach ($createProductDtos as $createProductDto) {
          $product_id = ProductRepository::create($createProductDto);
          PriceHistoryRepository::create($product_id, $createProductDto->price);
        }

        return new ResponseMessage("success", 200);
      } catch (Exception $e) {
        echo $e->getMessage();
        throw new Exception($e);
      }
    }

    public static function addMediasToProduct(int $product_id, array $createProductMediaDtos) {
      foreach ($createProductMediaDtos as &$media) {
        $count = MediaRepository::create($product_id, $media);
      }

      return new ResponseMessage("success", 200);
    }

    public static function makeDefaultMedia(int $product_id, int $media_id) {
      $rowsAffected = MediaRepository::makeDefault($product_id, $media_id);

      if ($rowsAffected == 0) {
        throw new Error("não atualizado");
      }

      return new ResponseMessage("success", 200);
    }

    public static function home(): array {
      return ProductRepository::home(); 
    }

    public static function list(?int $pCategory = null, ?string $pname = null): array {
      return ProductRepository::list($pCategory, $pname);
    }

    public static function listToShopcart(string $ids): array {
      $products =  ProductRepository::list();
      $returnedProducts = [];
      $arr = explode(',', $ids);

      foreach($products as &$product) {
        $result = in_array($product->id, $arr);
        if ($result) {
          array_push($returnedProducts, $product);
        }
      }

      return $returnedProducts;
    }


    public static function read(int $id): GetProductDto|null {
      return ProductRepository::read($id);
    }

  }
?>