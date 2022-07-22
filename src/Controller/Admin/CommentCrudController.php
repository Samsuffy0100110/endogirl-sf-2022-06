<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Comments')
            ->setEntityLabelInSingular('Comment')
            ->setPageTitle('index', 'Administration des Commentairess')
            ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->setLabel('Utilisateur'),
            TextField::new('summary')
                ->setLabel('Commentaire'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormat('d/m/Y H:i'),
            BooleanField::new('isPublished')
                ->setLabel('Publié ?'),
        ];
    }
}
