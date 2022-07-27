<?php

namespace App\Form\Forum;

use DateTime;
use App\Entity\User;
use App\Entity\Forum\Topic;
use App\Entity\Forum\Subject;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre du sujet',
                    'class' => 'form-control',
                ],
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => 'Contenu du sujet',
                    'class' => 'form-control',
                ],
            ])
            // ->add('createdAt', DateType::class, [
            //     'data' => new DateTime(),
            // ])
            // ->add('subject', EntityType::class, [
            //     'class' => Subject::class,
            //     'choice_label' => 'name',
            //     'placeholder' => 'Choose a subject',
            // ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'nickname',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
