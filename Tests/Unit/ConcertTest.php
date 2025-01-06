<?php

namespace App\Tests;

use App\Entity\Concert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConcertTest extends KernelTestCase
{
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $concert = new Concert();
        $concert->setName('23')
            ->setDetails('TestDétails')
            ->setDetails2('TestDétails2');
                
            
            

        $errors = $container->get('validator')->validate($concert);

        $this->assertCount(0, $errors);

       
    }
}
