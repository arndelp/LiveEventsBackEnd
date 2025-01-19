<?php

namespace App\Form;

use App\Entity\Alert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            
            ->add('Message1')
            ->add('Message2')
            ->add('Activer', SubmitType::class)
=======
            ->add('Message1')
            ->add('Message2')
            ->add('Envoyer', SubmitType::class)
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }
}
