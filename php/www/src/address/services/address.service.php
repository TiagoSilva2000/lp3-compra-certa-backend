<?php
  require_once (__DIR__ . '/../repositories/address.repository.php');
  class AddressService {

    public static function create(int $user_id, CreateAddressDto $createAddressDto): GetAddressDto {
      return AddressRepository::create($user_id, $createAddressDto);
    }

    public static function read(int $address_id): GetaddressDto {
      return AddressRepository::read($address_id);
    }

    public static function list(int $user_id): array {
      return AddressRepository::list($user_id);
    }

    public static function update(int $address_id, CreateAddressDto $updateAddressDto): GetUpdatedAddressDto {
      return AddressRepository::update($address_id, $updateAddressDto);
    }

    public static function makeDefault(int $address_id): ResponseMessage {
      return AddressRepository::makeDefault($address_id);
    }

    public static function delete(int $address_id): ResponseMessage {
      return AddressRepository::delete($address_id);
    }    
  }
?>