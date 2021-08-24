<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Type;
use App\Data\SearchData;
use App\Entity\Category;
use App\Entity\Producer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher...'
                ]
            ])
            ->add('categories', EntityType::class, [
                "label" => false,
                'required' => false,
                "class" => Category::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                }
            ])
            ->add('types', EntityType::class, [
                "label" => false,
                'required' => false,
                "class" => Type::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.title', 'ASC');
                }
            ])
            ->add('marks', EntityType::class, [
                "label" => false,
                'required' => false,
                "class" => Mark::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => false,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.title', 'ASC');
                }
            ])
            ->add('producers', EntityType::class, [
                "label" => false,
                'required' => false,
                "class" => Producer::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => false,
                "query_builder" => function (EntityRepository $er) {
                    return $er->createQueryBuilder('pr')
                        ->orderBy('pr.title', 'ASC');
                }
            ])
            ->add('min', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ]
            ])
            ->add('max', NumberType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
