<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Name cannot be blank.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s]+$/',
                        'message' => 'The name should only contain letters and numbers.',
                    ]),
                ],
            ])
            ->add('date', null, [
                'constraints' => [
                    new NotNull(['message' => 'Name cannot be blank.']),
                    new GreaterThan([
                        'value' => 'today',
                        'message' => 'The date must be after today.',
                    ]),
                ],
            ])
            ->add('nbrParticipants', null, [
                'constraints' => [
                    new NotNull(['message' => 'Name cannot be blank.']),
                    new Positive(),
                    new LessThan(['value' => 100, 'message' => 'The number of participants must be less than 100.']),
                ],
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Name cannot be blank.']),
                ],
            ])
            ->add('coach_id', null, [
                'constraints' => [
                    new NotNull(['message' => 'Name cannot be blank.']),
                ],
            ])
            ->add('imageUrl', FileType::class, [
                'label' => 'Image (JPEG or PNG file)',
                'required' => false,
                'mapped' => true,
                'attr' => ['accept' => 'image/jpeg, image/png'],
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Maximum size allowed is {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPEG or PNG image file.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}