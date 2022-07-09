<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Frage*',
                'label_attr' => ['class' => 'text-danger'],
                'attr' => ['class' => 'is-invalid']
            ])
            ->add('difficulty', ChoiceType::class, [
                'label' => 'Schwierigkeitsgrad*',
                'label_attr' => ['class' => 'text-danger'],
                'attr' => ['class' => 'is-invalid'],
                'choices' => ['einfach' => 1, 'mittel' => 2, 'schwer' => 3],
            ])
            ->add('Topic', EntityType::class, [
                'label' => 'Themenauswahl',
                'class' => Topic::class,
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Speichern'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
