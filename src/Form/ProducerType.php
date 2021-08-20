<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Producer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProducerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Label"
            ])
            ->add('products', EntityType::class, [
                "label" => "Produits",
                "class" => Product::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producer::class,
        ]);
    }
}
