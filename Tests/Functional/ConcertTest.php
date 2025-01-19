<?php

namespace App\Tests\Functional;


use App\Entity\Day;
use App\Entity\User;
use App\Entity\Concert;
use App\Entity\Location;
use App\Entity\Schedule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConcertTest extends WebTestCase
{
    //Tester la création d'un évènement (CREATE)//////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testIfCreateConcertIsSuccessfull(): void
    {
        //créer un client
        $client = static::createClient();

        // Recup urlGenerator
        $urlGenerator = $client->getContainer()->get('router');

        // Recup entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        // Recup de l'utilisateur d'id 11
        $user = $entityManager->find(User::class, 11);
        // Connection de l'utilisateur
        $client->loginUser($user);

        // Se rendre sur la page d'ajout de concert
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('concert.edit'));

        
        // Gérer  le formulaire


        $form = $crawler->filter('form[name=concert]')->form([
            'concert[name]' => "test",
            'concert[location]' => '31',
            'concert[day]' => '16',
            'concert[schedule]' => '66',
            'concert[details]' => "test",
            'concert[details2]' => "test2"
        ]);
        // Soumettre le formulaire
        $client->submit($form);

        // Gérer la redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        // Gérer l'alert box et la route
        $this->assertSelectorTextContains('div.alert-success', 'a été ajouté avec succès');

        $this->assertRouteSame('concert.list.alls');       

       
    }


    // Tester la lecture d'un évènement (READ)////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function testIfListeningConcertIsSuccessfull(): void
    {
        //créer un client
        $client = static::createClient();

        // Recup urlGenerator
        $urlGenerator = $client->getContainer()->get('router');

        // Recup entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        // Recup de l'utilisateur d'id 11
        $user = $entityManager->find(User::class, 11);
        // Connection de l'utilisateur
        $client->loginUser($user);
        //Se rendre sur la page de vision des concerts
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('concert.list.alls'));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('concert.list.alls');  
    }

    // Tester la modification d'un évènement ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // public function testIfUpdateConcertIsSuccessfull(): void
    // {
    //     //créer un client
    //     $client = static::createClient();

    //     // Recup urlGenerator
    //     $urlGenerator = $client->getContainer()->get('router');

    //     // Recup entity manager
    //     $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    //     // Recup de l'utilisateur d'id 11
    //     $user = $entityManager->find(User::class, 11);
    //     // Connection de l'utilisateur
    //     $client->loginUser($user);
    //     // Recup le concert ayant le nom DJ Vortex
    //     $concert = $entityManager -> getRepository(Concert::class)->findOneByName('Test');
        
    //     //Aller sur la page d'édition
    //     $crawler = $client->request(
    //         Request::METHOD_GET,
    //         $urlGenerator->generate('concert.edit', ['id' => $concert->getId()])
    //     );
    //     // TEster si on a une réponse
    //     $this->assertResponseIsSuccessful();

    //     //Modifier le nom et les détails
    //     $form = $crawler->filter('form[name=concert]')->form([
    //         'concert[name]' => "DJ Vortex",
    //         'concert[details]' => "Détails modifiés",
    //     ]);

    //     // soumettre le formulaire
    //     $client->submit($form);

    //     // Tester su on a une réponse
    //     $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    //     //SUivre la redirection
    //     $client->followRedirect();

    //     // Tester si on a le message d'alerte contenant 'a été mis a jour avec succès'
    //     $this->assertSelectorTextContains('div.alert-success', 'a été mis à jour avec succès');

    // }

    // Tester la suppression d'un évènement////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // public function testIfDeleteAConcertIsSuccessfull(): void
    // {
    //     //créer un client
    //     $client = static::createClient();

    //     // Recup urlGenerator
    //     $urlGenerator = $client->getContainer()->get('router');

    //     // Recup entity manager
    //     $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    //     // Recup de l'utilisateur d'id 11
    //     $user = $entityManager->find(User::class, 11);
    //     // Connection de l'utilisateur
        

    //     $concert = $entityManager -> getRepository(Concert::class)->findOneByName('DJ Vortex');

    //     $client->loginUser($user);
         
    //     $crawler = $client->request(
    //         Request::METHOD_DELETE,
    //         $urlGenerator->generate('concert.delete', ['id' => $concert->getId()])
    //     );

       
    //     // Tester si on a une réponse
    //     $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        

    //     //SUivre la redirection
    //     $client->followRedirect();

    //     // Tester si on a le message d'alerte contenant 'L'évènement a été supprimé avec succès'
    //     $this->assertSelectorTextContains('div.alert-success', "L'évènement a été supprimé avec succès");

        
    // }


}





       