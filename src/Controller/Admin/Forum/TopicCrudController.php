<?php

namespace App\Controller\Admin\Forum;

use DateTime;
use App\Entity\Forum\Topic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TopicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Topic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
            ->setEntityLabelInPlural('Topic')
            ->setEntityLabelInSingular('Topics')
            ->setPageTitle('index', 'Administration des Topics du Forum')
            ->setPaginatorPageSize(10);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Topic'),
            TextareaField::new('content')
                ->setLabel('Contenu du topic'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormat('dd-MM-Y HH:mm')
                ->setTimezone('Europe/Paris'),
            AssociationField::new('subject')
                ->setLabel('Sujet'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex()
                ->hideOnForm(),
        ];
    }
}
