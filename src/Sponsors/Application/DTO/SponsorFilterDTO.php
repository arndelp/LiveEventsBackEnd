<?php
namespace App\Sponsors\Application\DTO;

class SponsorFilterDTO
{
    public ?string $type = null;

    public function __construct(array $data = [])
    {
        $this->type = $data['type'] ?? null;
    }
}