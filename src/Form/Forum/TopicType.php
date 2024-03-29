<?php

namespace App\Form\Forum;

use App\Service\Slugify;
use App\Entity\Forum\Topic;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TopicType extends AbstractType
{
    private Slugify $slug;

    public function __construct(Slugify $slugify)
    {
        $this->slug = $slugify;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre du topic',
                    'class' => 'form-control',
                ],
                ]
            )
            ->add(
                'content',
                CKEditorType::class,
                [
                'attr' => ['data-editor' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Contenu du sujet',
                ],
                'config_name' => 'light',
                'label' => 'Contenu',
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
            'data_class' => Topic::class,
            ]
        );
    }
}
