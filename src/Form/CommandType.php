<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Command;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, [
                "label" => "Montant"
            ])
            ->add('registration_date',  DateType::class, [
                "widget" => "single_text",
                "label" => "Date d'enregistrement"
            ])
            ->add('status', ChoiceType::class, [
                "choices" => [
                    'en attente' => 'en attente',
                    'en cours' => 'en cours',
                    'livrée' => 'livrée'
                ]
            ])
            ->add('user', EntityType::class, [
                "label" => "Membre",
                "class" => User::class,
                "choice_label" => "email",
                "multiple" => false,
                "expanded" => false,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.email', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
