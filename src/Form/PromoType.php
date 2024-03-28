<?php

namespace App\Form;

use App\Entity\Promo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;


class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pourcentage')
            ->add('validite')
            ->add('isActive')
           // ->add('users')
           ->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => function(User $user) {
                return $user->getNom() . ' ' . $user->getPrenom(); 
            },
            'multiple' => false, // Allow only single selection
            'expanded' => false, // Use a dropdown instead of checkboxes
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promo::class,
        ]);
    }
}
