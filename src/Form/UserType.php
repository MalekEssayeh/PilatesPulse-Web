<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Nom must contain only letters.',
                ]),
            ],
        ])
        ->add('prenom', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Prenom must contain only letters.',
                ]),
            ],
        ])
        ->add('mdp', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'off'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('mail', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter an email address',
                ]),
            ],
        ])
        ->add('role', ChoiceType::class, [
            'choices' => [
                'User' => 'client',
                'Admin' => 'admin',
                'Coach' => 'coach',
            ],
            'multiple' => false,
        ])
        ->add('numTel', null, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[0-9]+$/',
                    'message' => 'NumTel must contain only numbers.',
                ]),
            ],
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
