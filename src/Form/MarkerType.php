<?php

namespace App\Form\Type;

use App\Form\PositionType;
use App\Document\Marker;
use Symfony\Component\Form\AbstractType;
use Doctrine\ODM\MongoDB\Types\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('id')
            ->add('name')
            ->add('zIndex')
            ->add('type')
            ->add('position', PositionType::class)
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