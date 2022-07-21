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

class RegisterType extends AbstractType
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'label_attr' => [
                        'class' => 'form_label',
                    ],
                    'attr' => [
                        'placeholder' => 'Ton mot de passe',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form_label',
                    ],
                    'attr' => [
                        'placeholder' => 'Confirmation de ton mot de passe',
                    ],
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-outline-warning',
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
