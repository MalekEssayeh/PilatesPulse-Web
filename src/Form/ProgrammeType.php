<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Programme;
use App\Entity\Exercice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomprogramme')
            ->add('dureeprogramme')
            ->add('difficulteprogramme', ChoiceType::class, [
                'choices' => [
                    'Hard' => 'Difficile',
                    'Medium' => 'Moyenne',
                    'Easy' => 'Facile',
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Listexercice', EntityType::class, [
                'class' => Exercice::class,
                'choice_label' => 'nomexercice',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
