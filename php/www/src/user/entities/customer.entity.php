<?php
  require_once('./user.entity.php');
  require_once('../../order/entities/order.entity.php');

  class Customer extends User {
    private Address $defaultAddress;
    private PaymentOption $defaultPaymentOption;

    public function __construct (
      string $email,
      string $first_name,
      string $last_name,
      string $password,
      string $phone,
      string $cpf,
      private float $totalSpent = 0,
      private int $totalBought = 0,
      private array $addresses = [],
      private array $wishlist = [],
      private array $paymentOptions = [],
      private array $orders = [],
    ) {
      parent::__construct(
        $email, 
        $first_name, 
        $last_name, 
        $password, 
        $phone, 
        $cpf);
      parent::setAccount(new Account(parent::getuid(), "customer"));
      if (count($this->paymentOptions) > 0)
        $this->defaultPaymentOption = $this->paymentOptions[0];

      if (count($this->addresses) > 0)
        $this->defaultAddress = $this->addresses[0];
    }

    public function createOrder (
      Address $address, 
      array $products,
      float $total,
      PaymentOption $paymentOption
    ) {
      $order = new Order(new Payment($paymentOption, "CREATED", $total), $products, $this->uid, $address);
      array_push($orders, $order);

      return $order;
    }

    public function cancelOrder(string $orderCode) {
      $idx = array_search($orderCode, $this->orders);
      unset($this->orders[$idx]);
    }

    public function addAddress(Address $address) {
      array_push($this->addresses, $address);
    }
    
    public function removeAddress(string $addressCode) {
      $idx = array_search($addressCode, $this->addresses);
      unset($this->addresses[$idx]);
    }

    public function addPaymentOpton(PaymentOption $paymentOption) {
      array_push($this->paymentOptions, $paymentOption);
    }

    public function removePaymentOption(string $paymentOptionCode) {
      $idx = array_search($paymentOptionCode, $this->paymentOptions);
      unset($this->paymentOptions[$idx]);
    }

    public function addToWishlist(Product $product) {
      array_push($this->wishlist, $product);
    }

    public function removeFromWishlist(string $prodCode) {
      $idx = array_search($prodCode, $this->wishlist);
      unset($this->wishlist[$idx]);
    }

    public function setDefaultAddress(Address $address) {
      $this->defaultAddress = $address;
    }

    public function setDefaultPaymentOption(PaymentOption $payOpt) {
      $this->defaultPaymentOption = $payOpt;
    }

    public function rateProduct(Product $product, float $rate) {
      $product->setRating($rate);
    }

    public function rateOrder(Order $order, float $rate) {
      $order->setRating($rate);
    }

    public function setOrderAsReceive(Order $order) {
      $order->setStatus("RECEIVED");
    }

    public function getUser(): User {
      return $this->user;
    }

    public function getUserUid(): string {
      return $this->userUid;
    }

    public function getTotalSpent(): float {
      return $this->totalSpent;
    }

    public function changeTotalSpent(float $amount): float {
      return $this->totalSpent += $amount;
    }

    public function getTotalBought(): int {
      return $this->totalBought;
    }

    public function changeTotalBought(int $amount): int {
      return $this->totalBought += $amount;
    }


    /**
     * Get the value of defaultAddress
     */ 
    public function getDefaultAddress()
    {
        return $this->defaultAddress;
    }

    /**
     * Set the value of defaultAddress
     *
     * @return  self
     */ 
    /**
     * Get the value of defaultPaymentOption
     */ 
    public function getDefaultPaymentOption()
    {
        return $this->defaultPaymentOption;
    }

    /**
     * Set the value of defaultPaymentOption
     *
     * @return  self
     */ 
  }

?>