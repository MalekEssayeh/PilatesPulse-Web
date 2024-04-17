<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Name cannot be blank.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s]+$/',
                        'message' => 'The name should only contain letters (capital or not) and numbers.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Description cannot be blank.']),
                ],
            ])
            ->add('duration', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Duration cannot be blank.']),
                    new Positive(['message' => 'Duration must be a positive number.']),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Duration must be greater than 0.',
                    ]),
                ],
            ])
            ->add('coach_id', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Coach ID cannot be blank.']),
                ],
            ])
            ->add('event', EntityType::class, [
                'class' => Event::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank(['message' => 'Event cannot be blank.']),
                ],
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(['message' => 'Time cannot be blank.']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
