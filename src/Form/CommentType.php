<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'summary',
                CKEditorType::class,
                [
                'attr' => ['data-editor' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Votre commentaire',
                ],
                'config_name' => 'light',
                'label' => 'Commentaire',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                'label' => 'Envoyer',
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
            'data_class' => Comment::class,
            ]
        );
    }
}
