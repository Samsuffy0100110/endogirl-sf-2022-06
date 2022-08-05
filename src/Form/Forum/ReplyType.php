<?php

namespace App\Form\Forum;

use DateTime;
use App\Entity\Forum\Reply;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', CKEditorType::class, [
                'attr' => ['data-editor' => true],
                'config_name' => 'light',
                'label' => 'Réponse',
            ])
            ->add('createdAt', DateTimeType::class, [
                'attr' => [
                    'hidden' => 'hidden',
                ],
                'data' => new DateTime(),
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-outline-warning',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reply::class,
        ]);
    }
}
