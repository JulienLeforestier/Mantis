<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Type;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Producer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre"
            ])
            ->add('price', NumberType::class, [
                "label" => "Prix"
            ])
            ->add('stock')
            // ->add('picture', FileType::class, [
            //     "mapped" => false,
            //     "required" => false,
            //     "constraints" => [
            //         new File([
            //             "mimeTypes" => ["image/gif", "image/jpeg", "image/png"],
            //             "mimeTypesMessage" => "Les formats autorisés sont gif, jpg et png",
            //             "maxSize" => "2048k",
            //             "maxSizeMessage" => "Le fichier ne doit pas faire plus de 2Mo"
            //         ])
            //     ]
            // ])
            ->add('picture')
            ->add('description', TextType::class, [
                "label" => "Déscription"
            ])
            ->add('category', EntityType::class, [
                "label" => "Catégorie",
                "class" => Category::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('mark', EntityType::class, [
                "label" => "Éditeur",
                "class" => Mark::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('producer', EntityType::class, [
                "label" => "Producteur",
                "class" => Producer::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('type', EntityType::class, [
                "label" => "Genre",
                "class" => Type::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
