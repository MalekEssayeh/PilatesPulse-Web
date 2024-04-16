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


            ->add('productdescription', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please insert a description for your product'
                    ]),
                ]
            ])

            ->add('priceproduct', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Price cannot be blank.'
                    ]),
                    new Assert\Type([
                        'type' => 'numeric',
                        'message' => 'Price must be a number.',
                    ]),
                    new Assert\PositiveOrZero([
                        'message' => 'Price must be a positive number.'
                    ]),
                ]
            ])
            ->add('stock', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Stock cannot be blank.'
                    ]),
                    new Assert\Type([
                        'type' => 'integer',
                        'message' => 'Stock must be an integer.',
                    ]),
                    new Assert\PositiveOrZero([
                        'message' => 'Stock must be a positive number or zero.'
                    ]),
                ]
            ])
            ->add('idcategory', null, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Category cannot be blank.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
