<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\Attendence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AttendenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ClassId',EntityType::class,[
                'class' => Classes::class,
                'mapped' =>true,
                'choice_label' => function($choice){
                    return $choice->getClassName();
                },
                // 'choice_value' => function($choice){
                //     return $choice;
                // },
                'attr' => array()
            ])
            ->add('StudentId',EntityType::class,[
                'class' => Student::class,
                'choice_label' => function($choice){
                    return $choice->getName();
                },
            ])
            ->add('Status',ChoiceType::class,[
                'choices'  => [
                    'Absent' => 'Teacher',
                    'Present' => 'Present'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendence::class,
        ]);
    }
}
