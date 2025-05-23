<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@retrospin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $_ENV['ADMIN_PASSWORD'] ?? throw new \RuntimeException('ADMIN_PASSWORD not set');
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('user@retrospin.com');
        $user2->setRoles(['ROLE_USER']);
        $password2 = $_ENV['USER_PASSWORD'] ?? throw new \RuntimeException('USER_PASSWORD not set');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, $password2));
        $manager->persist($user2);

        $manager->flush();
    }
}
