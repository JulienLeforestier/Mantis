<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\PromotionalCode;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PromotionalCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('reduction', NumberType::class, [
                "label" => "Réduction en %"
            ])
            ->add('user', EntityType::class, [
                "label" => "Membre",
                "class" => User::class,
                "choice_label" => "email",
                "multiple" => false,
                "expanded" => false,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.title', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromotionalCode::class,
        ]);
    }
}
