<?php

namespace App\Concerts\UI\Controller;






use App\Concerts\UI\Form\ConcertType;
use App\Concerts\Domain\Entity\Concert;
use App\Concerts\Application\DTO\ConcertDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Concerts\Application\UseCase\GetConcert;
use App\Concerts\Application\UseCase\SaveConcert;
use App\Concerts\Application\Mapper\ConcertMapper;
use App\Concerts\Application\UseCase\DeleteConcert;
use App\Concerts\Application\UseCase\GetPaginatedConcerts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ConcertController extends AbstractController
{
    

    public function indexAlls(GetPaginatedConcerts $getPaginatedConcerts, int $page, int $nbre): Response
    {
        $data = $getPaginatedConcerts->execute($page, $nbre);

        return $this->render('@Concert/index.html.twig', [
            'concerts' => $data['concerts'],
            'isPaginated' => true,
            'nbrePage' => $data['nbrePage'],
            'page' => $page,
            'nbre' => $nbre,
        ]);
    }


    public function detail(GetConcert $getConcert, int $id): Response
    {
        $concert = $getConcert->execute($id);

        if (!$concert) {
            $this->addFlash('error', "L'évènement n'existe pas");
            return $this->redirectToRoute('concert.list.alls');
        }

        return $this->render('@Concert/detail.html.twig', ['concert' => $concert]);
    }


    public function saveConcert(?Concert $concert, Request $request, SaveConcert $saveConcert, ConcertMapper $concertMapper): Response 
    {
        $new = false;
         // si le concert n'existe pas création d'un nouvel objet Concert
        if (!$concert) {
            $new = true;
            $dto = new ConcertDTO();
        } else { 
            //sinon récupération des données par le mapper 
            $dto = $concertMapper->toDTO($concert);
        }

        //Création du formulaire avec les données de $dto (contenant le concert ou rien)
        $form = $this->createForm(ConcertType::class, $dto);
         //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request (données du formulaire)
        $form->handleRequest($request);

      
        //Est-ce que le formulaire est valid et soumis
        if ($form->isSubmitted() && $form->isValid()) {
           //récupération des données et on les transmet au dto
            $dto = $form->getData();
            //Appel au useCase. On lui passe: le DTO, $new (booleen si c'est une création ou une édition, le nom de l'utilisateur)
            $saveConcert->execute($dto, $new, $this->getUser());
            //Création du Flash message de création d'un nouveau concert / ou de modification du concert
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "L'évènement". $message);
            //Redirection vers la liste des concerts
            return $this->redirectToRoute('concert.list.alls');
        } else {
            //Sinon on affiche le formulaire à corriger  (alias pour twig et l'architecture en couche)
            return $this->render('@Concert/edit-concert.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    
  public function delete(DeleteConcert $deleteConcert, GetConcert $getConcert, int $id): Response
{

    $concert = $getConcert->execute($id);

    if ($concert) {
         //Récupération de l'id et envoi au useCase
        $deleteConcert->execute($id);
        $this->addFlash('success', "L'évènement a été supprimé avec succès");
    } else {
        $this->addFlash('error', "Evènement inexistant");
    }

    return $this->redirectToRoute('concert.list.alls');
}
}