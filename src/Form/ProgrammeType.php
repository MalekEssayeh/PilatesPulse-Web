<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Programme;
use App\Entity\Exercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Count;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomprogramme', null, [
                'constraints' => [
                    new NotNull(['message' => 'Program name cannot be empty.']),
                    new Length(['min' => 2, 'minMessage' => 'Program name must be at least {{ limit }} characters long.'])
                ]
            ])
            ->add('dureeprogramme', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Program duration cannot be empty.']),
                    new Positive(['message' => 'Program duration must be a positive number.'])
                ]
            ])
            ->add('difficulteprogramme', ChoiceType::class, [
                'choices' => [
                    'Hard' => 'Difficile',
                    'Medium' => 'Moyenne',
                    'Easy' => 'Facile',
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Listexercice', EntityType::class, [
                'class' => Exercice::class,
                'choice_label' => 'nomexercice',
                'expanded' => true,
                'multiple' => true,
                'constraints' => [
                    new NotNull(['message' => 'Select at least one exercise.']),
                    new Count(['min' => 1, 'minMessage' => 'Select at least one exercise.'])
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
