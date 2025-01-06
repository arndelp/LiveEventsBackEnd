<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{

//Test de connectio=n si le login et mot de passe sont bons
    public function testIfLoginIsSuccessful(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate('app_login'));

        $form = $crawler->filter("form[name=login]")->form([
            "username" => "arndelp@yahoo.fr",
            "password" => "123456"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('concert.list.alls');
        
    }

//Test si le mot de passse est faux
    public function testIfPasswordIsWrong(): void
    {
        $client = static::createClient();

        
        $urlGenerator = $client->getContainer()->get("router");

        $crawler = $client->request('GET', $urlGenerator->generate('app_login'));

        $form = $crawler->filter("form[name=login]")->form([
            "username" => "arndelp@yahoo.fr",
            "password" => "123456_"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('app_login');

        $this->assertSelectorTextContains("div.alert-danger", "Invalid credentials.");
        
    }
}
