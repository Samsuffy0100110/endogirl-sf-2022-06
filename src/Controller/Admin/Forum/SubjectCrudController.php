<?php

namespace App\Controller\Admin\Forum;

use App\Entity\Forum\Subject;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subject::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Sujets')
            ->setEntityLabelInSingular('Sujet')
            ->setPageTitle('index', 'Administration des Sujets du Forum')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('Sujet'),
            TextareaField::new('summary')
                ->setLabel('Déscription du sujet'),
            AssociationField::new('category')
                ->setLabel('Catégorie'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex(),
        ];
    }
}
