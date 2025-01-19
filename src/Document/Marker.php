<?php

declare(strict_types=1);

namespace App\Document;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
<<<<<<< HEAD

=======
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;


#[ODM\Document(collection: 'markers')]
#[ApiResource]
#[GetCollection(extraProperties: ['doctrineMongodb' => ['execute_options' => ['allowDiskUse' => true]]])]
<<<<<<< HEAD

=======
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
class Marker
{
    #[ODM\Id(strategy: 'INCREMENT')]
    public ?int $id = null;

    #[ODM\Field]
    public string $key;

    #[ODM\FIeld]
    public float $lat;

    #[ODM\Field]
    public float $lng;

    #[ODM\Field]
    public string $title;

    #[ODM\Field]
    public string $image;

    #[ODM\Field]
    public string $width;

    #[ODM\Field]
    public string $height;


    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key) 
    {
        $this->key = $key;

        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat)
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function setLng(float $lng)
    {
        $this->lng = $lng;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width)
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height)
    {
        $this->height = $height;

        return $this;
    }


}