<?php
  require_once (__DIR__ . '/../repositories/address.repository.php');
  class AddressService {

    public static function create(int $user_id, CreateAddressDto $createAddressDto): GetAddressDto {
      return AddressRepository::create($user_id, $createAddressDto);
    }

    public static function findOrCreate(int $customer_id, CreateOrderAddressDto $createOrderAddressDto): GetaddressDto {
      $address = null;
      if ($createOrderAddressDto->id != null) {
        $address = AddressRepository::read($createOrderAddressDto->id);
      }



      if ($address == null) {
        $address = AddressService::create($customer_id, new CreateAddressDto(
          $createOrderAddressDto->cep,
          $createOrderAddressDto->street,
          $createOrderAddressDto->neighbour,
          $createOrderAddressDto->city,
          $createOrderAddressDto->state,
          $createOrderAddressDto->country,
          $createOrderAddressDto->house_id,
          $createOrderAddressDto->details,
          $createOrderAddressDto->owner_phone,
        ));
      }
      
      return $address;
    }

    public static function read(int $address_id): GetaddressDto {
      return AddressRepository::read($address_id);
    }

    public static function list(int $user_id): array {
      return AddressRepository::list($user_id);
    }

    public static function update(int $address_id, CreateAddressDto $updateAddressDto): ResponseMessage {
      $rowsAffected = AddressRepository::update($address_id, $updateAddressDto);
      if ($rowsAffected != 1) {
        return new ResponseMessage(
          "success",
          200
        );
      }

      return new ResponseMessage(
        "error",
        500
      );
    }

    public static function makeDefault(int $user_id, int $address_id): ResponseMessage {
      return AddressRepository::makeDefault($user_id, $address_id);
    }

    public static function delete(int $address_id): ResponseMessage {
      return AddressRepository::delete($address_id);
    }    
  }
?>