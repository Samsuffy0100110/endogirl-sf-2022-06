<?php

namespace App\Controller\Admin;

use App\Entity\Links;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LinksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Links::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Links')
            ->setEntityLabelInSingular('Link')
            ->setPageTitle('index', 'Administration des Liens utiles')
            ->setPaginatorPageSize(10);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextEditorField::new('link')
                ->setLabel('Nom du lien'),
            TextField::new('summary')
                ->setLabel('Déscription'),
        ];
    }
    
}
