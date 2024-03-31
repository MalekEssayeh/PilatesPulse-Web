<?php

namespace App\Form;

use App\Entity\Promo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints as Assert;


class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pourcentage', null, [
                'constraints' => [
                    new NotBlank(), // not blank
                    new Type('numeric'), //  numeric
                    new Range(['min' => 0, 'max' => 100]), // within the specified range
                ],
            ])
            ->add('validite', null, [
                'constraints' => [
                    new Assert\GreaterThan([ //date ba3ed lyoum only 
                        'value' => 'today',
                        'message' => 'The date must be a future date.'
                    ])
                ]
            ])
           // ->add('isActive')
           ->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => function(User $user) {
                return $user->getNom() . ' ' . $user->getPrenom(); 
            },
            'multiple' => false, // Allow only single selection
            'expanded' => false, // Use a dropdown instead of checkboxes
        ]);
        // Add event listener to dynamically set isActive field
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $promo = $event->getData();

            // Assuming 'validite' is a DateTime object
            $validite = $promo->getValidite();

            // Get the current date
            $currentDate = new \DateTime();

            // Set isActive based on the comparison of validite with current date
            $isActive = ($validite > $currentDate);

            // Set the value of isActive field
            $promo->setIsActive($isActive);
        });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
        ]);
    }
}
