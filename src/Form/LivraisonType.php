<?php

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('methodePay', ChoiceType::class, [
                'choices'  => [
                    'Cash_On_Delivery' => "Cash_On_Delivery",
                    'Use_Credit_Card' => "Use_Credit_Card",
            
                ],
            ])
            ->add('adresseLiv', null, [
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateAdresseLiv']),
                ],
            ])
            ->add('dateLiv', null, [
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateDateLiv']),
                ],
            ])
            ->add('phone', null, [
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^\d{8}$/',
                        'message' => 'Invalid phone format. Please provide 8 digits.',
                    ]),
                ],
            ])

;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }

    public function validateAdresseLiv($value, ExecutionContextInterface $context): void
    {
        // Validate the format of adresseLiv
        if (!preg_match('/^Tunisie,([^,]+),([^,]+)$/i', $value, $matches)) {
            $context->buildViolation('Invalid adresseLiv format. Please use "Tunisie,Government,Residence Name".')
                ->addViolation();
            return;
        }

        // Get the governorate from the provided value
        $governorate = strtolower($matches[1]);

        // Specify the allowed governorates
        $allowedGovernorates = [
            'tunis', 'ariana', 'ben arous', 'la manouba', 'nabeul', 'zaghouan',
            'bizerte', 'béja', 'jendouba', 'le kef', 'siliana', 'kairouan',
            'kasserine', 'sidi bouzid', 'sousse', 'monastir', 'mahdia', 'sfax',
            'kebili', 'gabès', 'medenine', 'tataouine', 'gafsa', 'tozeur'
        ];

        // Check if the provided governorate is in the allowed list
        if (!in_array($governorate, $allowedGovernorates)) {
            $context->buildViolation('Invalid governorate provided in adresseLiv.')
                ->addViolation();
        }
    }

    public function validateDateLiv($value, ExecutionContextInterface $context): void
    {
        // Validate if dateLiv is in the future
        $today = new \DateTime();
        if ($value < $today) {
            $context->buildViolation('The date should be today or in the future.')
                ->addViolation();
        }
    }

}
