<?
  require_once('../entities/customer.entity.php');
  class CustomerRepository {

    public static function createCustomer(): Customer {
      return new Customer("adaddasdad", 45.84, 80);
    }

    public static function getCustomer(): Customer {
      return new Customer("adaddasdad", 45.84, 80);
    }

    public static function updateCustomer(): Customer {
      return new Customer("adaddasdad", 45.84, 80);
    }

    public static function deleteCustomer(): void {}

  }

?>