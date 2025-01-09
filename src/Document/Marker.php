<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;


#[ODM\Document(collection: 'markers')]
#[ApiResource]
#[GetCollection(extraProperties: ['doctrineMongodb' => ['execute_options' => ['allowDiskUse' => true]]])]
class Marker
{
    #[ODM\Id(strategy: 'INCREMENT')]
    public ?int $id = null;

    #[ODM\Field]
    public string $key;

    #[ODM\FIeld]
    public Decimal128 $lat;

    #[ODM\Field]
    public Decimal128 $lng;

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

    public function setKey(string $key): Article
    {
        $this->key = $key;

        return $this;
    }

    public function getLat(): Decimal128
    {
        return $this->lat;
    }

    public function setLat(string $lat): Article
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): Decimal128
    {
        return $this->lng;
    }

    public function setLng(string $lng): Article
    {
        $this->lng = $lng;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Article
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Article
    {
        $this->image = $image;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width): Article
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): Article
    {
        $this->height = $height;

        return $this;
    }


}