<?php

namespace App\Tests\Fonctional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/login');

        $this->assertResponseIsSuccessful();
       
    }
}
