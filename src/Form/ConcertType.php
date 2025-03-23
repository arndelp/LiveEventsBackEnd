<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\Style;
use App\Entity\Concert;
use App\Entity\Location;
use App\Entity\Schedule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => "Nom",
            ])
            
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'location',
                'label' => "Scène",
            ])
            ->add('day', EntityType::class, [
                'class' => Day::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'day',
                'label' => "Date",
            ])
            ->add('schedule', EntityType::class, [
                'class' => Schedule::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'schedule',
                'label' => "Horaire",
            ])

                        
            ->add('photo', FileType::class, [
                'required' => false,
                'label' => 'Photo',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg,
                            image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide',
                    ])
                ]
             ]) 
             
            ->add('details', null, [
                "label" => "Informations",
            ])
                
            ->add('details2', null, [
                "label" => "Historique",
            ])
            ->add('Envoyer', SubmitType::class)

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
 