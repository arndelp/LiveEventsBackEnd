<?php

namespace App\Form;

use App\Document\Camp;
use App\Form\PositionType;
use Symfony\Component\Form\AbstractType;
use Doctrine\ODM\MongoDB\Types\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;


class CampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
       
        $builder                           
                ->add('name', null, [
                    'label' => 'Nom'
                ])            
                                
                ->add('position', PositionType::class, [
                    'label' => 'Coordonnées GPS'
                ])

                ->add('photo', FileType::class, [
                    'required' => false,
                    'label' => 'Icône',
                    'mapped' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '100k',
                            'mimeTypes' => [
                                'image/jpeg,
                                image/png',
                                'image/jpeg'
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide',
                        ])
                    ]
                 ]) 

                ->add('width', null, [
                    'label' => 'Largeur du POI (par défaut: 40)'
                ])

                ->add('height', null, [
                    'label' => 'Hauteur du POI (par défaut: 40)'
                ])

                ->add('info', null, [
                    'label' => 'Information'
                ])
                
                ->add('Envoyer', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Camp::class, 
            
            
            
        ]);
    }
}
