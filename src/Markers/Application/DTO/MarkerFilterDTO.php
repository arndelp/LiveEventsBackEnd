<?php
namespace App\Markers\Application\DTO;

class MarkerFilterDTO
{
    public ?string $type = null;

    public function __construct(?string $type)
    {
        $this->type = $type;
    }
}