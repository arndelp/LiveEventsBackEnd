<?php

namespace App\Alert\Application\UseCase;



use App\Alert\Domain\Entity\Alert;
use App\Alert\Domain\Repository\AlertRepositoryInterface;



class DeleteAlert
{
    public function __construct(private AlertRepositoryInterface $alertRepository) {}

    public function execute(Alert $alert): void
    {
        $this->alertRepository->deleteAlert($alert);
    }
}