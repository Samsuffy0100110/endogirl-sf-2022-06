<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Votre email'],
                ]
            )
            ->add(
                'subject',
                TextType::class,
                [
                'label' => 'C\'est à quel sujet ? :)',
                'attr' => ['placeholder' => 'Votre sujet'],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                'label' => 'Votre message',
                'attr' => ['placeholder' => 'Votre message'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Contact::class,
            ]
        );
    }
}
