<?php

namespace App\Form\Type;

use App\Document\Shop;
use App\Form\PositionType;
use Symfony\Component\Form\AbstractType;
use Doctrine\ODM\MongoDB\Types\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ShopType extends AbstractType
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
                 ]) 

                ->add('width', null, [
                    'label' => 'Largeur du POI'
                ])

                ->add('height', null, [
                    'label' => 'Hauteur du POI'
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
            'data_class' => Shop::class, 
            
            
            
        ]);
    }
}
