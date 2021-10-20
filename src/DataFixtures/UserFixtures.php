<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setUsername("test");
        $user->setRoles(["ROLE_ADMIN"]);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'test123'
        ));

        $manager->persist($user);
        $manager->flush();
    }
}
