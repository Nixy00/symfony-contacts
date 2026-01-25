<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')->hideOnForm(),

            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            EmailField::new('email', 'Email'),

            AssociationField::new('category', 'Catégorie')
                ->setFormTypeOption('choice_label', 'name')
                ->setFormTypeOption('query_builder', function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                })
                ->formatValue(function ($value, $entity) {
                    return $value?->getName();
                }),
        ];
    }
}
