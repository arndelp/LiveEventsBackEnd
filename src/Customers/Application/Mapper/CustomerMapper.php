<?php

namespace App\Customers\Application\Mapper;

use App\Customers\Domain\Entity\Customer;
use App\Customers\Application\DTO\CustomerDTO;


class CustomerMapper
{
public function toEntity(CustomerDTO $dto): Customer
{
    $customer = new Customer();
    $customer->setFirstname($dto->firstname);
    $customer->setLastname($dto->lastname);
    $customer->setEmail($dto->email);    
    $customer->setStyle($dto->style);
    $customer->setStreetnumber($dto->streetnumber);
    $customer->setStreet($dto->street);
    $customer->setPostalcode($dto->postalcode);
    $customer->setCity($dto->city);
    $customer->setCountry($dto->country);
    $customer->setPhone($dto->phone);

    return $customer;
}

public function toDTO(Customer $customer): CustomerDTO
{
    $dto = new CustomerDTO();    
    $dto->firstname = $customer->getFirstname();
    $dto->lastname = $customer->getLastname();
    $dto->email = $customer->getEmail();
    $dto->password = $customer->getPassword();
    $dto->style = $customer->getStyle();
    $dto->streetnumber = $customer->getStreetnumber();
    $dto->street = $customer->getStreet();
    $dto->postalcode = $customer->getPostalcode();
    $dto->city = $customer->getCity();
    $dto->country = $customer->getCountry();
    $dto->phone = $customer->getPhone();

    return $dto;
}

}

