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

    public const USERS = [
        ['nickname' => 'Samsuffy', 'email' => 'samsuffy@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'samsuffy'],
        ['nickname' => 'admin', 'email' => 'gaelleyo@gmail.com', 'role' => ['ROLE_ADMIN'], 'password' => 'f6T3265i29'],
        ['nickname' => 'Gaelle', 'email' => 'gaelle@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'gaelle'],
        ['nickname' => 'Alessandra', 'email' => 'alessandra@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'sacha'],
        ['nickname' => 'Matthieu', 'email' => 'matthieu@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'matthieu'],
        ['nickname' => 'Maxime', 'email' => 'maxime@gmail.com', 'role' => ['ROLE_USER'], 'password' => 'maxime'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setNickname($userData['nickname']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['role']);
            $this->addReference($userData['nickname'], $user);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
