<?php
  require_once (__DIR__ . '/../repositories/order.repository.php');
  require_once (__DIR__ . '/../repositories/order-products.repository.php');
  require_once (__DIR__ . '/../repositories/order-tracking.repository.php');
  require_once (__DIR__ . '/../../payment/services/payment.service.php');
  require_once (__DIR__ . '/../../address/services/address.service.php');
  class OrderService {
    public static function create(int $customer_id, CreateOrderDto $createOrderDto): GetOrderDto {
      $paymentOption = PaymentService::findOrCreate($customer_id, $createOrderDto->payment);
      $address = AddressService::findOrCreate($customer_id, $createOrderDto->address);
      $payment = PaymentService::createPayment($paymentOption->id, $createOrderDto->total);
      $order = OrderRepository::create($customer_id, $payment, $address);
      $tracking = OrderTrackingRepository::create($order->id, new CreateOrderTrackingDto(
        new DateTime(),
        "preparing",
        "488888"
      ));
      foreach ($createOrderDto->products as &$product_id) {
        OrderProductRepository::create($order->id, $product_id);
      }


      $order->products = $createOrderDto->products;
      // $order->payment = $createOrderDto->payment;
      // $order->address = $createOrderDto->address;
      return $order;
    }
    
    public static function list(int $userId): array {
      $orders = OrderRepository::list($userId);
      foreach($orders as $order) {
        $order->products = OrderProductRepository::list($order->id);
        $order->tracking = OrderTrackingRepository::list($order->id);
      }

      return $orders;
    }

    public static function controlList(): array {
      $orders = OrderRepository::controlList();

      foreach($orders as $order) {
        $order->products = OrderProductRepository::list($order->id);
      }

      return $orders;
    }

    public static function read(int $orderId): GetOrderDto {
      
      return OrderRepository::read($orderId);
    }

    public static function updateStatus(int $orderId, string $orderStatus): ResponseMessage {
      $tracking = OrderTrackingRepository::create($orderId, new CreateOrderTrackingDto(
        new DateTime(),
        $orderStatus,
        "48888322"
      ));

      return new ResponseMessage("success", 200);
    }

    public static function setReceived(int $orderId): ResponseMessage  {
      $rowsAffected = OrderRepository::setReceived($orderId);

      return $rowsAffected != 1 ? new ResponseMessage("error", 500) : 
                                new ResponseMessage("success", 200);
    }

    public static function rate(int $orderId, int $productId, float $rating): ResponseMessage {
      //$rowsAffected = OrderRepository::rate($orderId, $productId, $rating);
      $rowsAffected = OrderProductRepository::rate($orderId, $productId, $rating);

      return $rowsAffected != 1 ? new ResponseMessage("error", 500) : 
                                new ResponseMessage("success", 200);
    }
  }
?>