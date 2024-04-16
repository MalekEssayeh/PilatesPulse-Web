<?php

namespace App\Form;

use App\Entity\Shoppingcart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Shoppingcart1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iduser')
            ->add('nameproduct')
            ->add('image')
            ->add('productdescription')
            ->add('priceproduct')
            ->add('quantity')
            ->add('idproduct')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shoppingcart::class,
        ]);
    }
}