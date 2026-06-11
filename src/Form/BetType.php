<?php

namespace App\Form;

use App\Entity\Bet;
use App\Twig\Components\EventCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'w-full bg-brand-dark border border-gray-700 rounded px-3 py-2 text-white font-bold focus:border-brand-red focus:ring-1 focus:ring-brand-red focus:outline-none transition',
                    'data-model' => 'debounce(500)|amount',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
