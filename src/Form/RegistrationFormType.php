<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Regex; 
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
    ->add('nom', TextType::class, [
        'constraints' => [
            new Assert\NotBlank(),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z]+$/',
                'message' => 'The name can only contain letters.',
            ]),
        ],
    ])
    ->add('prenom', TextType::class, [
        'constraints' => [
            new Assert\NotBlank(),
            new Assert\Regex([
                'pattern' => '/^[a-zA-Z]+$/',
                'message' => 'The surname can only contain letters.',
            ]),
        ],
    ])
        ->add('mail', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email([
                    'message' => 'The email "{{ value }}" is not a valid email.',
                ]),
            ],
        ])
        ->add('numTel', TelType::class, [
            'label' => 'Phone Number',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type([
                    'type' => 'numeric',
                    'message' => 'The phone number must be numeric.',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'label' => 'Password',
            'mapped' => false,
            'attr' => ['autocomplete' => 'off'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Assert\Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'label' => 'I agree to the terms and conditions',
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ])
        ->add('role', HiddenType::class, [
            'data' => 'client', // Set default role to 'client'
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
