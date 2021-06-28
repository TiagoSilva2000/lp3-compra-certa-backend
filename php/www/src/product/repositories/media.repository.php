<?php

  class MediaRepository {

    public static function create(int $product_id, CreateProductMediaDto $createProductMediaDto): int {
      try {
        $sql = Connection::$conn->prepare("
          INSERT INTO media
            (product_id, path, ext, main)
          VALUES
            (:product_id, :path, :ext, :main)
        ");
        $convertedMain =(int) $createProductMediaDto->main;
        $sql->bindParam(":product_id", $product_id);
        $sql->bindParam(":path", $createProductMediaDto->path);
        $sql->bindParam(":ext", $createProductMediaDto->ext);
        $sql->bindParam(":main", $convertedMain);
        $sql->execute();

        return Connection::$conn->lastInsertId();
      } catch (Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

    public static function makeDefault(int $product_id, int $media_id): int {
      try {
        $sql = Connection::$conn->prepare("
          UPDATE media
            SET main = 0
          WHERE product_id = :product_id AND main = 1
          UPDATE media
            SET main = 1
          WHERE id = :id
        ");
        $sql->bindParam(":product_id", $product_id);
        $sql->bindParam(":id", $media_id);
        $sql->execute();

        return $sql->rowCount();
      } catch(Exception $e) {
        echo "Error: " . $sql->errorInfo() . "<br>" . Connection::$conn->error;
        throw new Exception($e);
      }
    }

  }


?>