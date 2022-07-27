<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }

    const USERS = [
        ['nickname' => 'Samsuffy', 'email' => 'samsuffy@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'samsuffy'],
        ['nickname' => 'admin', 'email' => 'admin@admin.fr', 'role' => ['ROLE_ADMIN'], 'password' => 'admin'],
        ['nickname' => 'Gaelle', 'email' => 'gaelle@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'gaelle'],
        ['nickname' => 'Alessandra', 'email' => 'alessandra@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'sacha'],
        ['nickname' => 'Matthieu', 'email' => 'matthieu@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'matthieu'],
        ['nickname' => 'Maxime', 'email' => 'mxime@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'maxime'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setNickname($userData['nickname']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['role']);
            $this->addReference($userData['user'], $user);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $manager->flush();
        }
        // Création d’un utilisateur de type “contributeur” (= auteur)
        // $user = new User();
        // $user->setNickname('samsuffy');
        // $user->setEmail('user@user.fr');
        // $user->setRoles(['ROLE_USER']);
        // $this->addReference('samsuffy', $user);
        // $hashedPassword = $this->passwordHasher->hashPassword(
        //     $user,
        //     'userpassword'
        // );

        // $user->setPassword($hashedPassword);
        // $manager->persist($user);

        // // Création d’un utilisateur de type “administrateur”
        // $admin = new User();
        // $admin->setNickname('admin');
        // $admin->setEmail('admin@admin.fr');
        // $admin->setRoles(['ROLE_ADMIN']);
        // $this->addReference('admin', $admin);
        // $hashedPassword = $this->passwordHasher->hashPassword(
        //     $admin,
        //     'adminpassword'
        // );
        // $admin->setPassword($hashedPassword);
        // $manager->persist($admin);

        // // Sauvegarde des 2 nouveaux utilisateurs :
        // $manager->flush();
    }
}
