<?php
namespace App\Markers\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class MarkerFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Tous' => null,          // Valeur null pour désactiver le filtre
                    'Scène' => 'scene',
                    'Bar' => 'bar',
                    'Magasin' => 'shop',
                    'WC' => 'wc',
                    'entrée/sortie' => 'door',
                    'Parking' => 'parking'
                ],
                'expanded' => false,   // affiche les choix en boutons radio
                'multiple' => false,  // un seul choix possible
                'attr' => ['class' => 'form-select'], // Ajout de la classe Bootstrap ici
                'placeholder' => 'Choisir un type',
                'required' => false,  // pas obligatoire
                'label' => 'Filtrer par type',
            ]);
    }
}