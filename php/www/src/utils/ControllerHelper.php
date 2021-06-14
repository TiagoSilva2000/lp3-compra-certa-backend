<?php
  use Psr\Http\Message\ResponseInterface as Response;

  class ControllerHelper {

    public static function formatResponse(Response $response, mixed $content): Response {
      $arr = (array) $content;
      $payload = json_encode($arr);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-type', 'application/json');
    }
  }



?>