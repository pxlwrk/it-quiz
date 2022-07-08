<?php

namespace App\Form;

use App\Entity\EventSession;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel der Veranstaltung*',
                'label_attr' => ['class' => 'text-danger'],
                'attr' => ['class' => 'is-invalid']
            ])
            ->add('decription', TextType::class, [
                'label' => 'Kurze Beschreibung der Veranstaltung'
            ])
            ->add('eventDate', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'label' => 'Datum der Veranstaltung'
            ])
            ->add('Topics', EntityType::class, [
                'label' => 'Themenauswahl',
                'multiple' => 'true',
                'class' => Topic::class,
                'required' => false
            ])
//            ->add('isActive', CheckboxType::class, [
//                'row_attr' => ['class' => 'form-check form-switch mb-3'],
//                'label_attr' => ['class' => 'form-check-label'],
//                'attr' => ['class' => 'form-check-input'],
//                'label' => 'Aktiv schalten'
//            ])
            ->add('save', SubmitType::class, [
                'label' => 'Speichern'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventSession::class,
        ]);
    }
}
