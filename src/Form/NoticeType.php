<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Notice;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextareaType::class, [
                "label" => "Commentaire"
            ])
            ->add('note', ChoiceType::class, [
                "choices" => [
                    '★' => '1',
                    '★★' => '2',
                    '★★★' => '3',
                    '★★★★' => '4',
                    '★★★★★' => '5'
                ]
            ])
            ->add('registration_date', DateType::class, [
                "widget" => "single_text",
                "label" => "Date d'enregistrement"
            ])
            ->add('user', EntityType::class, [
                "label" => "Membre",
                "class" => User::class,
                "choice_label" => "email",
                "multiple" => false,
                "expanded" => false
            ])
            ->add('product', EntityType::class, [
                "label" => "Produit",
                "class" => Product::class,
                "choice_label" => "title",
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
            'data_class' => Notice::class,
        ]);
    }
}
