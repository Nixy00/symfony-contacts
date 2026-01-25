<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')->hideOnForm(),

            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),

            EmailField::new('email', 'Email'),

            ArrayField::new('roles', 'Rôles'),

            TextField::new('plainPassword', 'Mot de passe')
                ->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('required', false)
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('empty_data', '')
                ->setFormTypeOption('attr', [
                    'autocomplete' => 'new-password',
                ]),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }
}
