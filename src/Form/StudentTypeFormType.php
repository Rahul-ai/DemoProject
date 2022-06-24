<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Student;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StudentTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',TextType::class,[
                'attr' => array(
                    'class' =>'form-control',
                    'placeholder' => 'Student Name',
                ),
                ])

            ->add('Admission_Number', IntegerType::class,[
                'attr' => array(
                    'class' => 'mt-1 form-control',
                    'placeholder' => 'Admission Number'
                ), 
            ])

            ->add('classs', EntityType::class,[
                'class'=> Classes::class,
                'mapped' =>true,
                'choice_label' => function($choice){
                    return $choice->getClassName();
                },
                // 'choice_value' => function($choice){
                //     return $choice;
                // },
                'attr' => array(
                    'class' => 'mt-1 form-control'
                    
                )
            ]);         
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
