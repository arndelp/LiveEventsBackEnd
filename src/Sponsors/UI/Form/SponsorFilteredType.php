<?php

namespace App\Sponsors\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SponsorFilteredType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Récupération des valeurs distinctes passées dans les options
        $types = $options['types'] ?? [];

        // Création du tableau des choix pour le champ "type"
        // Préparer le tableau choices en ajoutant l'option "Tous" (null)
        $typeChoices = ['Tous' => null];
        foreach ($types as $type) {
            $typeChoices[$type] = $type;
        }


        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => $typeChoices,
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