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
    private DocumentManager $dm;
    private LoggerInterface $logger;

    public function __construct(DocumentManager $dm, LoggerInterface $logger)
    {
        $this->dm = $dm;
        $this->logger = $logger;
    }


#[Route('/marker/browse', name: 'marker_browse', methods: ['GET'])]
public function browse(Request $request): Response
    {
        $markerRepository = $this->dm->getRepository(Marker::class);
        $queryBuilder = $restaurantRepository->createQueryBuilder();
        $restaurants = $queryBuilder
                ->field('key')->equals('Bar 1')
                ->field('lat')->equals(48.6480495744828)
                ->field('lng')->equals(1.8157557433476355)
                ->field('image')->equals("../assets/bars.png")
                ->field('width')->equals("30 em")
                ->field('height')->equals("30 em")
                ->execute();
        return $this->render('marker/browse.html.twig', ['markers' => $markers]);
    }
}