<?php
declare(strict_types=1);
namespace App\Controller;

use App\Document\Marker;
use Psr\Log\LoggerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MarkerController extends AbstractController
{
  


#[Route('/marker/create', name: 'marker_create', methods: ['GET'])]
public function browse(DocumentManager $dm)
    {
        $marker = new Marker();
        $marker->setKey("Bar");
        $marker->setLat(48.6480495744828);
        $marker->setLng(1.8157557433476355);
        $marker->setTitle("Bar du château");
        $marker->setImage("../assets/bars.png");
        $marker->setWidth("30 em");
        $marker->setHeight("30 em");
    
        $dm->persist($marker);
        $dm->flush();
    
        return new Response('Created marker id ' . $marker->getId());
    }
}