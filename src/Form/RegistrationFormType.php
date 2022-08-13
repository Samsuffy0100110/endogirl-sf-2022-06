<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nickname',
                TextType::class,
                [
                'label' => 'Pseudo',
                'required' => true,
                'constraints' => [
                new Assert\NotBlank(
                    [
                    'message' => 'Pseudo requis',
                    ]
                ),
                new Assert\Length(
                    [
                    'min' => 3,
                    'max' => 50,
                    ]
                ),
                ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                new Assert\NotBlank(
                    [
                    'message' => 'Email requis',
                    ]
                ),
                new Assert\Email(
                    [
                    'message' => 'Email invalide',
                    ]
                ),
                ],
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                'type' => PasswordType::class,
                'first_options' => [
                'label' => 'Mot de passe',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                        'message' => 'Mot de passe requis',
                        ]
                    ),
                ],
                ],
                'second_options' => [
                'label' => 'Confirmez votre mot de passe',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(
                        [
                        'message' => 'Confirmation requise',
                        ]
                    ),
                    new Assert\Length(
                        [
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Confirmation trop courte',
                        'maxMessage' => 'Confirmation trop longue',
                        ]
                    ),
                ],
                'help' => 'Les mots de passe doivent être identiques et doivent contenir au moins une lettre minuscule,
                une lettre majuscule, un chiffre et un caractère spécial',
                ],
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                'label' => 'S\'inscrire',
                'attr' => [
                'class' => 'btn btn-outline-warning',
                ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => User::class,
            ]
        );
    }
}
