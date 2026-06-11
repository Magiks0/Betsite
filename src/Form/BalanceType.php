<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class BalanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('balance', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'w-full bg-gray-950 border border-gray-800 rounded-lg px-4 py-3 text-white font-bold focus:border-brand-red focus:ring-1 focus:ring-brand-red focus:outline-none transition',
                    'placeholder' => 'Montant à déposer...',
                    'min' => 1,
                ],
                'constraints' => [
                    new Positive(message: 'Le montant doit etre supérieur a 0'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
