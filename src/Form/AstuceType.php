<?php

namespace App\Form;

use App\Entity\Astuce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AstuceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
                'attr' => ['class' => "materialize-textarea", 'id' => "textarea1"],
                'required' => true
            ])
            ->add('date', HiddenType::class, [
                'attr' => ['id' => 'todayDate', 'value' => ''],
                'mapped' => false,
            ])
           ->add('categoris', HiddenType::class, [
            'mapped' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Astuce::class,
        ]);
    }
}
