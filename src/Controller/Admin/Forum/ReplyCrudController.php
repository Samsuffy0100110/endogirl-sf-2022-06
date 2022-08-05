<?php

namespace App\Controller\Admin\Forum;

use App\Entity\Forum\Reply;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ReplyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reply::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Reply')
            ->setEntityLabelInSingular('Replies')
            ->setPageTitle('index', 'Administration des Rponses du Forum')
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')
                ->setLabel('Auteur'),
            TextField::new('message')
                ->setLabel('Reply'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormat('dd-MM-Y HH:mm')
                ->setTimezone('Europe/Paris'),
            AssociationField::new('topic')
                ->setLabel('Topic'),
        ];
    }
}
