<?php
namespace App\Concerts\Application\DTO;

class ConcertFilterDTO
{
    public ?string $day = null;

    public ?string $schedule = null;

    public function __construct(array $data = []) 
    {
        $this->day = $data['day'] ?? null;
        $this->schedule = $data['schedule'] ?? null;
    }
}