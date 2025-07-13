<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\Style;
use App\Entity\Concert;
use App\Entity\Location;
use App\Entity\Schedule;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => "Nom",
                'required' => true,
            ])
            
            ->add('style', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'required' => true,
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
                'required' => true,
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
                'required' => true,
                'label' => "Date",
                'choices' => ["09/07/2027"=>"09/07/2027",
                            "10/07/2027"=>"10/07/2027",
                            "11/07/2027"=>'11/07/2027'],
                
            ])
            ->add('schedule', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'required' => true,
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
                'required' => true,
            ])
                
            ->add('details2', null, [
                "label" => "Historique",
                'required' => true,
            ])
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
 