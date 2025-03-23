<?php

namespace App\Form;


use App\Document\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options):void
        {
            $builder
                ->add('lat', null, [
                    'label' => 'Latitude (°)'
                ])
                ->add('lng', null, [
                    'label' => 'Longitude (°)'
                ])
                ;
        }
    
        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Position::class,
            ]);
        }
}

