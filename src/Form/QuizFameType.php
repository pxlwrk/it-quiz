<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizFameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('famename', TextType::class, [
                'label' => 'Dein Name',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('contactEmail', TextType::class, [
                'label' => 'Deine E-Mail-Adresse',
                'label_attr' => ['class' => 'text-white'],
                'attr' => ['class' => 'form-control-lg'],
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Absenden'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
