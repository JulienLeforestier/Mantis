<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextType::class, [
                "label" => "Commentaire"
            ])
            ->add('note')
            ->add('registration_date', DateType::class, [
                "widget" => "single_text",
                "label" => "Date d'enregistrement"
            ])
            ->add('user', EntityType::class, [
                "label" => "Membre",
                "class" => User::class,
                "choice_label" => "email",
                "multiple" => false,
                "expanded" => true
            ])
            ->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
