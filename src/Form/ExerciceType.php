<?php

namespace App\Form;

use App\Entity\Exercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints as Assert;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomExercice', null, [
            'constraints' => [
                new Assert\NotNull([
                    'message' => 'Exercise Name cannot be null.'
                ]),
                new Assert\Length([
                    'min' => 2,
                    'minMessage' => 'Exercise name must be more than 2 characters.'
                ])
            ]
        ])            ->add('DifficulteExercice', ChoiceType::class, [
                'choices' => [
                    'Hard' => 'Difficile',
                    'Medium' => 'Moyenne',
                    'Easy' => 'Facile',
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Muscle', ChoiceType::class, [
                'choices' => [
                    'Abdominaux' => 'Abdominaux',
                    'PlancherPelvin' => 'PlancherPelvin',
                    'Dos' => 'Dos',
                    'Fessiers' => 'Fessiers',
                    'Cuisses' => 'Cuisses',
                    'Epaules' => 'Epaules',
                    'Bras' => 'Bras',
                    'StabilisateurEpaule' => 'StabilisateurEpaule'
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Demonstration', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'An image must be chosen.'
                    ]),
                    new Assert\File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'], 
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF).',
                    ]),
                ],

            ])
            ->add('Video', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'a video must be chosen.'
                    ]),
                    new Assert\File([
                        'mimeTypes' => ['video/mp4', 'video/mpeg', 'video/quicktime'], 
                        'mimeTypesMessage' => 'Please upload a valid video file (MP4, MPEG, QuickTime).',
                    ]),
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
