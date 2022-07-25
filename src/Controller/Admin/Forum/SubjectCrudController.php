<?php

namespace App\Controller\Admin\Forum;

use App\Entity\Forum\Subject;
use App\Service\Slugify;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

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
            TextField::new('summary')
                ->setLabel('Déscription du sujet'),
            AssociationField::new('category')
                ->setLabel('Catégorie'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex(),
        ];
    }

}
