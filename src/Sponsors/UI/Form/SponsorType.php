<?php

namespace App\Sponsors\UI\Form;

use Symfony\Component\Form\AbstractType;
use App\Sponsors\Application\DTO\SponsorDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => "Nom",
            ])
            
            ->add('link', null, [
                'label' => "Adresse site",
            ])
                        
            ->add('logoSponsor', FileType::class, [               
                
             ]) 
             
            
            
            ->add('Envoyer', SubmitType::class)            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SponsorDTO::class,
        ]);
    }
}
 