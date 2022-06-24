<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'lable' => 'Student Name:'
                ])

            ->add('Admission_Number', IntegerType::class,[
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Admission Number'
                ),
                'lable' => 'Admission Number:' 
            ])

            ->add('classs', IntegerType::class,[
                'attr' => array(
                'class'=>'form-control',
                'placeholder'=> 'Select Class'),
                'lable' => 'Class:'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
