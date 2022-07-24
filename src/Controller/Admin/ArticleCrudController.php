<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
            ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre'),
            TextEditorField::new('content')
                ->setLabel('Contenu'),
            ImageField::new('picture')
                ->setBasePath('/images/pictures/')
                ->setUploadDir('public/images/pictures/')
                ->setUploadedFileNamePattern('[name].[extension]')
                ->setLabel('Image')
                ->setHelp('L\'image doit être au format jpg, jpeg, png ou gif et doit faire moins de 2Mo'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormat('d/m/Y H:i'),
            BooleanField::new('isPublished')
                ->setLabel('Publié ?'),
        ];
    }
}
