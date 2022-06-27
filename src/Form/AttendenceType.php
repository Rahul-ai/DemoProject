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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AttendenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ClassId',IntegerType::class,[
            ])

            ->add('StudentId',IntegerType::class, [
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
