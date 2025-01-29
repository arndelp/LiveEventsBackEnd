<?php

namespace App\Form\Type;


use App\Document\Stage;
use Symfony\Component\Form\AbstractType;
use Doctrine\ODM\MongoDB\Types\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('key')            
            ->add('info')
            ->add('lat')
            ->add('lng')
            
            ->add('icone', FileType::class, [
                'required' => false,
            ])
            ->add('width')
            ->add('height')
            ->add('Envoyer', SubmitType::class)

            ;

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}