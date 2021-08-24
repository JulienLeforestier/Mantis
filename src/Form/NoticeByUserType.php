<?php

namespace App\Form;

use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NoticeByUserType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
