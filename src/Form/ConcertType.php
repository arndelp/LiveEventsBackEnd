<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\Concert;
use App\Entity\Location;
use App\Entity\Schedule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'location',
            ])
            ->add('day', EntityType::class, [
                'class' => Day::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'day',
            ])
            ->add('schedule', EntityType::class, [
                'class' => Schedule::class,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'choice_label' => 'schedule',
            ])
            
            ->add('photo', FileType::class, [
                'required' => false,
             ]) 
             
            ->add('details')
                
            ->add('details2')
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
 