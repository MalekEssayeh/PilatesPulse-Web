<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameproduct', null, [
                'constraints' => [
                    new Assert\NotNull([
                        'message' => ' Name cannot be null.'
                    ]),
                ]
            ])

            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'please upload an image',
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'you should insert an image'
                    ]),
                    new Assert\File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF).',
                    ]),
                ],
            ])

            ->add('productdescription')
            ->add('priceproduct')
            ->add('stock')
            ->add('idcategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
