<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => "L'adresse {{ value }} n'est pas une adresse mail valide",
                    ]),
                ]
            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => "Mot de passe",
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut être vide',
                    ]),
                    new Length([
                        "max" => 255,
                        "maxMessage" => "Le mot de passe doit comporter 255 caractères maximum",
                        "min" => 8,
                        "minMessage" => "Le mot de passe doit comporter au moins 8 caractères"
                    ]),
                    new Regex([
                        "pattern" => "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",
                        "message" => "Le mot de passe doit comporter entre 8 et 20 caractères, une minuscule, une majuscule, un chiffre et un caractère spécial"
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Membre' => 'ROLE_USER'
                ],
                "label" => "Rôle(s)",
                "multiple" => true,
                "expanded" => true
            ])
            ->add('name', TextType::class, [
                "label" => "Nom",
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le nom doit comporter 50 caractères maximum",
                    ]),
                    new NotBlank([
                        "message" => "Le nom ne peut pas être vide"
                    ])
                ]
            ])
            ->add('first_name', TextType::class, [
                "label" => "Prénom",
                "constraints" => [
                    new Length([
                        "max" => 50,
                        "maxMessage" => "Le prénom doit comporter 50 caractères maximum",
                    ]),
                    new NotBlank([
                        "message" => "Le prénom ne peut pas être vide"
                    ])
                ]
            ])
            ->add('address', TextareaType::class, [
                "label" => "Adresse",
                "constraints" => [
                    new Length([
                        "max" => 255,
                        "maxMessage" => "L'adresse doit comporter 255 caractères maximum",
                    ]),
                    new NotBlank([
                        "message" => "L'adresse ne peut pas être vide"
                    ])
                ]
            ])
            ->add('zip_code', TextType::class, [
                "label" => "Code Postal",
                "constraints" => [
                    new Regex([
                        "pattern" => "#^((0[1-9])|([1-8][0-9])|(9[0-8]))[0-9]{3}$#",
                        "message" => "Le code postal n'est pas un code postal valide"
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                "label" => "Ville",
                "constraints" => [
                    new Length([
                        "max" => 100,
                        "maxMessage" => "La ville doit comporter 100 caractères maximum",
                    ]),
                    new NotBlank([
                        "message" => "La ville ne peut pas être vide"
                    ])
                ]
            ])
            ->add('phone_number', TelType::class, [
                "label" => "Téléphone *",
                "required" => false,
                "constraints" => [
                    new Length([
                        "max" => 12,
                        "maxMessage" => "Le téléphone doit comporter 12 caractères maximum",
                    ])
                ]
            ])
            ->add('isVerified', CheckboxType::class, [
                'label' => "Email vérifié",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
