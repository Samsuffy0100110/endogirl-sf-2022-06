<?php

namespace App\Controller\Admin;

use App\Entity\Links;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            ->setPaginatorPageSize(10)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextEditorField::new('link')
                ->setLabel('Nom du lien')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions(['config_name' => 'light']),
            TextareaField::new('summary')
                ->setLabel('Déscription'),
        ];
    }
    
}
