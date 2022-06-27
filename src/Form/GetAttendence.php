<?php

namespace App\Form;


use App\Entity\Classes;
use App\Entity\GetAtt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GetAttendence extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ClassId',EntityType::class,[
             'class' => Classes::class,
             'choice_label' => function($choice){
                return $choice->getClassName();
            },
             'attr' => array('class' => 'form-control')
            ])
            ->add('Date',DateType::class,[
                'attr' => array('class' => 'form-control')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
