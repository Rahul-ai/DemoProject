<?php

namespace App\Form;

use App\Entity\Employes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmployeTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',TextType::class,[
                'attr'=>array(
                    'class'=>'form-control',
                    'placeholder' => 'Employee Name'
                ),
                
            ])

            ->add('EmployeeCode',TextType::class,[
                'attr'=>array(
                    'class'=>'form-control',
                    'placeholder' => 'Employee Code'
                )
            ])

            ->add('Role',ChoiceType::class,[
                'choices'  => [
                    'Teacher' => 'Teacher',
                    'Admin' => 'Admin'
                ],
                'attr'=>array(
                    'class'=>'form-control',
                    'placeholder' => 'Role'
                )
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
        ]);
    }
}
