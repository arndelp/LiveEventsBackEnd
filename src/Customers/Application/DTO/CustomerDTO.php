<?php

namespace App\Customers\Application\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class CustomerDTO
{
    
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(max: 100)]
    public ?string $lastname = null;

    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(max: 100)]
    public ?string $firstname = null;
    
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    public ?string $email = null;

    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(max: 100)]
    public ?string $password = null;

  
    #[Assert\NotBlank(message: "Le style de musique préféré est obligatoire.")]
    #[Assert\Length(max: 50)]
    public ?string $style = null;

    #[Assert\NotBlank(message: "Le numéro de rue est obligatoire.")]
    #[Assert\Length(max: 10)]
    public ?string $streetnumber = null;

    #[Assert\NotBlank(message: "Le nom de rue est obligatoire.")]
    #[Assert\Length(max: 150)]
    public ?string $street = null;

    #[Assert\NotBlank(message: "Le code postal est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[0-9]{4,10}$/",
        message: "Le code postal doit contenir uniquement des chiffres (4 à 10 caractères)."
    )]
    public ?string $postalcode = null;

    #[Assert\NotBlank(message: "La ville est obligatoire.")]
    #[Assert\Length(max: 100)]
    public ?string $city = null;

    #[Assert\NotBlank(message: "Le pays est obligatoire.")]
    #[Assert\Length(max: 100)]
    public ?string $country = null;

    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^\+?[0-9\s\-\(\)]{7,20}$/",
        message: "Le numéro de téléphone n'est pas valide."
    )]
    public ?string $phone = null;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $password,
        string $style,
        string $streetnumber,
        string $street,
        string $postalcode,
        string $city,
        string $country,
        string $phone,
    ) {        
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->style = $style;
        $this->streetnumber = $streetnumber;
        $this->street = $street;
        $this->postalcode = $postalcode;
        $this->city = $city;
        $this->country = $country;
        $this->phone = $phone;
    }
}
        /*
        Dans un DTO, le constructeur sert à garantir :
            la complétude des données,
            un contrat clair (tous les champs obligatoires sont fournis dès le départ),
            une meilleure robustesse (moins d’objets « incomplets » qui circulent dans l'appli).
       */


