<?php
  require_once('../../extendables/base.entity.php');

  class Address extends BaseUIDEntity {

    public function __construct (
      private int $customerId,
      private string $street,
      private string $neighbour,
      private string $buildingCode,
      private string $zipcode,
      private string $city,
      private string $state,
      private string $country,
      private string $owner_name,
      private string $owner_phone,
      private string $notes,
      private bool $isDefault,
    ) {}

      /**
       * Get the value of customerId
       */
      public function getCustomerId()
      {
            return $this->customerId;
      }

      /**
       * Set the value of customerId
       */
      public function setCustomerId($customerId) : self
      {
            $this->customerId = $customerId;

            return $this;
      }

      /**
       * Get the value of street
       */
      public function getStreet()
      {
            return $this->street;
      }

      /**
       * Set the value of street
       */
      public function setStreet($street) : self
      {
            $this->street = $street;

            return $this;
      }

      /**
       * Get the value of neighbour
       */
      public function getNeighbour()
      {
            return $this->neighbour;
      }

      /**
       * Set the value of neighbour
       */
      public function setNeighbour($neighbour) : self
      {
            $this->neighbour = $neighbour;

            return $this;
      }

      /**
       * Get the value of buildingCode
       */
      public function getBuildingCode()
      {
            return $this->buildingCode;
      }

      /**
       * Set the value of buildingCode
       */
      public function setBuildingCode($buildingCode) : self
      {
            $this->buildingCode = $buildingCode;

            return $this;
      }

      /**
       * Get the value of zipcode
       */
      public function getZipcode()
      {
            return $this->zipcode;
      }

      /**
       * Set the value of zipcode
       */
      public function setZipcode($zipcode) : self
      {
            $this->zipcode = $zipcode;

            return $this;
      }

      /**
       * Get the value of city
       */
      public function getCity()
      {
            return $this->city;
      }

      /**
       * Set the value of city
       */
      public function setCity($city) : self
      {
            $this->city = $city;

            return $this;
      }

      /**
       * Get the value of state
       */
      public function getState()
      {
            return $this->state;
      }

      /**
       * Set the value of state
       */
      public function setState($state) : self
      {
            $this->state = $state;

            return $this;
      }

      /**
       * Get the value of country
       */
      public function getCountry()
      {
            return $this->country;
      }

      /**
       * Set the value of country
       */
      public function setCountry($country) : self
      {
            $this->country = $country;

            return $this;
      }

      /**
       * Get the value of owner_name
       */
      public function getOwnerName()
      {
            return $this->owner_name;
      }

      /**
       * Set the value of owner_name
       */
      public function setOwnerName($owner_name) : self
      {
            $this->owner_name = $owner_name;

            return $this;
      }

      /**
       * Get the value of owner_phone
       */
      public function getOwnerPhone()
      {
            return $this->owner_phone;
      }

      /**
       * Set the value of owner_phone
       */
      public function setOwnerPhone($owner_phone) : self
      {
            $this->owner_phone = $owner_phone;

            return $this;
      }

      /**
       * Get the value of notes
       */
      public function getNotes()
      {
            return $this->notes;
      }

      /**
       * Set the value of notes
       */
      public function setNotes($notes) : self
      {
            $this->notes = $notes;

            return $this;
      }

      /**
       * Get the value of isDefault
       */
      public function getIsDefault()
      {
            return $this->isDefault;
      }

      /**
       * Set the value of isDefault
       */
      public function setIsDefault($isDefault) : self
      {
            $this->isDefault = $isDefault;

            return $this;
      }
  }


?>