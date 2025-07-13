<?php
namespace App\Concerts\Domain\Repository;

interface EventRepositoryInterface
{
    public function findUniqueEventDays(): array;
    public function findEventsByDay(string $day): array;

}