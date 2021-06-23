<?php
  class ResponseMessage {
    public function __construct(
      public string $message,
      public int $http_code
    ) {}
  }
?>