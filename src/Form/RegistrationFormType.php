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
        ->add('nickname', TextType::class, [
            'label' => 'Pseudo',
            'label_attr' => [
                'class' => 'form_label',
            ],
            'required' => true,
            'attr' => [
                'placeholder' => 'Ton pseudo',
                'class' => 'form-control',
                'minlength' => 3,
                'maxlength' => 50,
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Pseudo requis',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 50,
                    'minMessage' => 'Pseudo trop court',
                    'maxMessage' => 'Pseudo trop long',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form_label',
            ],
            'required' => true,
            'attr' => [
                'placeholder' => 'Ton email',
                'class' => 'form-control',
                'minlength' => 3,
                'maxlength' => 50,
            ],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Email requis',
                ]),
                new Assert\Length([
                    'min' => 3,
                    'max' => 50,
                    'minMessage' => 'Email trop court',
                    'maxMessage' => 'Email trop long',
                ]),
                new Assert\Email([
                    'message' => 'Email invalide',
                ]),
            ],
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form_label',
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 50,
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Mot de passe requis',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Mot de passe trop court',
                        'maxMessage' => 'Mot de passe trop long',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial',
                    ]),
                ],
            ],
            'second_options' => [
                'label' => 'Confirmez votre mot de passe',
                'label_attr' => [
                    'class' => 'form_label',
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 3,
                    'maxlength' => 50,
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Confirmation requise',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Confirmation trop courte',
                        'maxMessage' => 'Confirmation trop longue',
                    ]),
                ],
            ],
        ])
        // ->add('plainPassword', PasswordType::class, [
        //     'label' => 'Mot de passe',
        //     'mapped' => false,
        //     'attr' => ['autocomplete' => 'new-password'],
        //     'constraints' => [
        //         new NotBlank([
        //             'message' => 'Merci d\'entrer un mot de passe',
        //         ]),
        //         new Length([
        //             'min' => 3,
        //             'minMessage' => 'Your password should be at least {{ limit }} characters',
        //             'max' => 50,
        //         ])
        //     ],
        // ])
        ->add('submit', SubmitType::class, [
            'label' => 'S\'inscrire',
            'attr' => [
                'class' => 'btn btn-outline-warning',
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
