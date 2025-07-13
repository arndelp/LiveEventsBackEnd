<?php

namespace App\Markers\UI\Form;

use Symfony\Component\Form\AbstractType;
use App\Markers\Application\DTO\MarkerDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', ChoiceType::class, [            
            'expanded' => false,
            'multiple' => false,
            'required' => false,
            'choices' => ['Scène'=>'scene',
                        'Bar/Restaurant'=>'bar', 
                        'Parking'=>'parking', 
                        'Entrée/Sortie'=>'door', 
                        'Shop'=>'shop', 'WC'=>'wc', 
                        'Camping'=>'camping'],
            'label' => "Type",
        ])
            ->add('name', null, [
                "label" => 'Nom'
            ])
            ->add('latitude', null, [
                "label" => 'Latitude (°)',                 
            ])
            ->add('longitude', null, [
                "label" => 'Longitude (°)',                             
            ])
           
            ->add('details', null, [
                "label" => "Informations"
            ])
            
            ->add('zIndex', ChoiceType::class, [            
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choices' => ['1'=>'1',
                            '2'=>'2', 
                            '3'=>'3', 
                            '4'=>'4', 
                            '5'=>'5',
                        ],
                "label" => "priorité",                
            ])
            
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MarkerDTO::class,
        ]);
    }
}
