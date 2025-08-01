<?php

namespace App\Concerts\UI\Form;

use Symfony\Component\Form\AbstractType;
use App\Concerts\Application\DTO\ConcertDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => "Nom",
            ])
            
            ->add('style', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'label'=> 'style',
                'choices' => ["Électro"=>"Électro",
                            "Pop"=>"Pop",
                            "Rock"=>"Rock",
                            "Hip-hop / Rap"=>"Hip-hop / Rap",
                            "Reggae"=>"Reggae"],                
            ])

            ->add('location', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,                
                'label'=> 'location',
                'choices' => ["Scène CHÂTEAU"=>"Scène CHÂTEAU",
                            "Scène GWERNIG"=>"Scène GWERNIG",
                            "Scène GLENMOR"=>"Scène GLENMOR",
                            "Scène KEROUAC"=>"Scène KEROUAC",
                            "Scène GRALL"=>"Scène GRALL"],                
            ])

            ->add('day', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,               
                'label' => "Date",
                'choices' => ["09/07/2027"=>"09/07/2027",
                            "10/07/2027"=>"10/07/2027",
                            "11/07/2027"=>'11/07/2027'],
                
            ])
            ->add('schedule', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,                
                'label' => "Horaire",
                'choices' => ["17:00 - 18:00"=> "17:00 - 18:00",
                            "18:00 - 19:00"=>"18:00 - 19:00",
                            "19:00 - 20:00"=>"19:00 - 20:00",
                            "20:00 - 21:00"=>"20:00 - 21:00",
                            "21:00 - 22:00"=>"21:00 - 22:00",
                            "22:00 - 23:00"=>"22:00 - 23:00",
                            "23:00 - 00:00"=>"23:00 - 00:00"],
                
            ])
                        
            ->add('photo', FileType::class, [               
                
             ]) 
             
            ->add('details', null, [
                "label" => "Informations",
            ])
                
            ->add('details2', null, [
                "label" => "Historique",
            ])
            ->add('Envoyer', SubmitType::class)            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcertDTO::class,
        ]);
    }
}
 