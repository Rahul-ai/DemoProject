<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Attendence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class GetAttendence extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ClassId',EntityType::class,[
             'class' => Classes::class,
             'attr' => array()
            ])
            ->add('Date',DateType::class,[
               'attr' => array()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendence::class,
        ]);
    }
}
