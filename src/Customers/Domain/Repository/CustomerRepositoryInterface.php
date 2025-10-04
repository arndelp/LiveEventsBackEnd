<?php

namespace App\Customers\Domain\Repository;

use App\Customers\Domain\Entity\Customer;

interface CustomerRepositoryInterface 
{
     public function findById(int $id): ?Customer;
     public function deleteCustomer(Customer $customer): void;
     public function findPaginated(int $page, int $limit): array;
     public function countAll(): int;
     public function save(Customer $customer): void;
     public function findByEmail(string $email): ?Customer;
}
