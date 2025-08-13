<?php
namespace App\Concerts\UI\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Récupération des valeurs distinctes passées dans les options
        $days = $options['days'] ?? [];
        $schedules = $options['schedules'] ?? [];

         // Création du tableau des choix pour le champ "day"
        // Préparer le tableau choices en ajoutant l'option "Tous" (null)
        $dayChoices = ['Tous' => null];
        foreach ($days as $day) {
            $dayChoices[$day] = $day; // clé = label affiché, valeur = valeur envoyée
        }

        // Création du tableau des choix pour le champ "schedule"
        $scheduleChoices = ['Tous' => null];
        foreach ($schedules as $schedule) {
            $scheduleChoices[$schedule] = $schedule;
        }

        $builder
        // Ajout du champ "day" (liste déroulante)
            ->add('day', ChoiceType::class, [
                'choices' => $dayChoices,
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-select'],
                'placeholder' => 'Choisir le jour',
                'required' => false,
                'label' => 'Filtrer par jour',
            ])
            // Ajout du champ "schedule" (liste déroulante)
            ->add('schedule', ChoiceType::class, [
                'choices' => $scheduleChoices,
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-select'],
                'placeholder' => 'Choisir un horaire',
                'required' => false,
                'label' => 'Filtrer par horaire',
            ]);
    }

    //Définit les options par défaut pour ce formulaire.
    //Permet au formulaire d'accepter les option days et schedules même si elles ne sont pas fournies
    // Ajouter la déclaration des options autorisées
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'days' => [],         // par défaut un tableau vide
            'schedules' => [],    // par défaut un tableau vide
        ]);
    }
}
