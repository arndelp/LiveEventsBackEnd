<?php
namespace App\Sponsors\UI\Controller;



use App\Sponsors\UI\Form\SponsorType;
use App\Sponsors\Domain\Entity\Sponsor;
use Doctrine\ORM\EntityManagerInterface;
use App\Sponsors\Application\DTO\SponsorDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Sponsors\Application\UseCase\GetSponsor;
use App\Sponsors\Application\UseCase\SaveSponsor;
use App\Sponsors\Application\Mapper\SponsorMapper;
use App\Sponsors\Application\UseCase\DeleteSponsor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Sponsors\Application\UseCase\GetPaginatedSponsors;
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class SponsorController extends AbstractController
{
    //constructeur pour injecter le repository (utile pour delete)
    private SponsorRepositoryInterface $sponsorRepository;

    public function __construct(SponsorRepositoryInterface $sponsorRepository)
    {
        $this->sponsorRepository = $sponsorRepository;
    }



    //liste de tout les sponsors
    public function indexAlls(GetPaginatedSponsors $getPaginatedSponsors, int $page, int $nbre): Response
    {
        $data = $getPaginatedSponsors->execute($page, $nbre);

        return $this->render('@Sponsor/index.html.twig', [
            'sponsors' => $data['sponsors'],
            'isPaginated' => true,
            'nbrePage' => $data['nbrePage'],
            'page' => $page,
            'nbre' => $nbre,
        ]);
    }

    
    //Recherche des détails pour un seul sponsor         
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(GetSponsor $getSponsor, int $id): Response
    {
        $sponsor = $getSponsor->execute($id);

        if (!$sponsor) {
            $this->addFlash('error', "Le partenaire n'existe pas");
            return $this->redirectToRoute('sponsor.list.alls');
        }

        return $this->render('@Sponsor/detail.html.twig', ['sponsor' => $sponsor]);
    }
       
    
    //ajout/édition d'un sponsor
   
    public function saveSponsor(?Sponsor $sponsor ,Request $request, SaveSponsor $saveSponsor, SponsorMapper $sponsorMapper): Response 
    {
        $new = false;
         // si le sponsor n'existe pas création d'un nouvel objet Sponsor
        if (!$sponsor) {
            $new = true;
            $dto = new SponsorDTO();
        } else {
            //sinon récupération des données par le mapper 
            $dto = $sponsorMapper->toDTO($sponsor);
        }

        //Création du formulaire avec les données de $dto (contenant le sponsor ou rien)
        $form = $this->createForm(SponsorType::class, $dto);
         //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request (données du formulaire)
        $form->handleRequest($request);

      
        //Est-ce que le formulaire est valid et soumis
        if ($form->isSubmitted() && $form->isValid()) {
           //récupération des données et on les transmet au dto
            $dto = $form->getData();
            //Appel au useCase. On lui passe: le DTO, $new (booleen si c'est une création ou une édition, le nom de l'utilisateur)
            $saveSponsor->execute($dto, $new, $this->getUser());
            //Création du Flash message de création d'un nouveau sponsor / ou de modification du sponsor
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "Le partenaire". $message);
            //Redirection vers la liste des sponsors
            return $this->redirectToRoute('sponsor.list.alls');
        } else {
            //Sinon on affiche le formulaire à corriger  (alias pour twig et l'architecture en couche)
            return $this->render('@Sponsor/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

public function delete(int $id, DeleteSponsor $deleteSponsor): Response
{
   
    if ($id) {       
        $deleteSponsor->execute($id);

        $this->addFlash('success', "Le partenaire a été supprimé avec succès");
    } else {
        $this->addFlash('error', "Partenaire inexistant");
    }

    return $this->redirectToRoute('sponsor.list.alls');
}



}
