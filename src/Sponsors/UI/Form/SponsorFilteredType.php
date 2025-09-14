<?php

namespace App\Sponsors\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorFilteredType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                        'Tous' => null,
                        'Spiritueux'=>'spiritueux',
                        'Vin'=>'vin',
                        'Bière'=>'bière',
                        'Soda'=>'soda',
                        'Sport'=>'sport', 
                        'Fast-food'=>'fast-food',
                        'Café'=>'café',
                        'Banque'=>'banque', 
                        'Assurance'=>'assurance',
                        'Autre...'=>'autre'],
                'expanded' => false,   // affiche les choix en boutons radio
                'multiple' => false,  // un seul choix possible
                'attr' => ['class' => 'form-select'], // Ajout de la classe Bootstrap ici
                'placeholder' => 'Choisir un type',
                'required' => false,  // pas obligatoire
                'label' => 'Filtrer par type',
            ]);
    }

     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'types' => [],         // par défaut un tableau vide
            
        ]);
    }
}