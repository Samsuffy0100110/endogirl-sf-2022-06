<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Articles')
            ->setEntityLabelInSingular('Article')
            ->setPageTitle('index', 'Administration des Articles')
            ->setPaginatorPageSize(10)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre'),
            TextEditorField::new('content')
                ->setLabel('Contenu')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions(['config_name' => 'light']),
            ImageField::new('picture')
                ->setBasePath('/images/pictures/')
                ->setUploadDir('public/images/pictures/')
                ->setUploadedFileNamePattern('[name].[extension]')
                ->setLabel('Image')
                ->setHelp('L\'image doit être au format jpg, jpeg, png ou gif et doit faire moins de 2Mo'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormat('dd-MM-Y HH:mm')
                ->setTimezone('Europe/Paris'),
            BooleanField::new('isPublished')
                ->setLabel('Publié ?'),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),
        ];
    }
}
