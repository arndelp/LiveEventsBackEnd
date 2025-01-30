<?php

namespace App\Form\Type;

use App\Document\Marker;
use App\Form\PositionType;
use Symfony\Component\Form\AbstractType;
use Doctrine\ODM\MongoDB\Types\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
       
        $builder                           
                ->add('name', null, [
                    'label' => 'Nom'
                ])            
                ->add('type', ChoiceType::class, [
                    'choices' => [''=>0 ,'BAR'=>'BAR', 'SCENE'=>'SCENE']
                ])
                ->add('zIndex', ChoiceType::class, [
                    'label' => 'Priorité',
                    'choices' => [1=>0 ,2=>1,3=>2,4=>3, 5=>4, 6=>5]
                    ])

                ->add('position', PositionType::class, [
                    'label' => 'Coordonnées GPS'
                ])
                ->add('Envoyer', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Marker::class, 
            
            
            
        ]);
    }
}
