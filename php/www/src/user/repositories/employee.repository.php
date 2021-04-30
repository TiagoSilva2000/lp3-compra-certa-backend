<?
  require_once('../entities/employee.entity.php');

  class EmployeeRepository {

    public static function createEmployee(): Employee {
      return new Employee("adasdad", 45, new DateTime(), new DateTime());
    }

    public static function getEmployee(): Employee {
      return new Employee("adasdad", 45, new DateTime(), new DateTime());
    }

    public static function updateEmployee(): Employee {
      return new Employee("adasdad", 45, new DateTime(), new DateTime());
    }

    public static function deleteEmployee(): void {}

  }

?>