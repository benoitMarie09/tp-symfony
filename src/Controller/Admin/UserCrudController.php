<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $password = TextField::new('password')
            ->setLabel("Password")
            ->setFormType(PasswordType::class)
            ->setFormTypeOption('empty_data', '')
            ->hideOnIndex(); // il ne sera visible que dans le formulaire

            return [
                EmailField::new('email'),
                TextField::new('name'),
                $password,
                ChoiceField::new('roles', 'Roles') // Définition du champ Roles à multiple choix
                    ->allowMultipleChoices()
                    ->autocomplete()
                    ->setChoices([  'User' => 'ROLE_USER',
                                    'Admin' => 'ROLE_ADMIN']
                                )
                ];
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        return $user;
    }
    
}
