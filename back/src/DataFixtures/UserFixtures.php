<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        $roles= ['ROLE_USER', 'ROLE_ADMIN'];

        $pwd = '$2y$13$xRLZ0dJJEJQP9Tw3wH5wvOWe2wVLMFkjGDOHXuEctFp7aBKrfC3K6'; //user

        $object = (new User())
            ->setEmail('user1@user.fr')
            ->setUsername('user')
            ->setPassword($pwd)
            ->setRoles(['ROLE_USER'])
            ->setIsVerify(true)
        ;
        $manager->persist($object);


        $object = (new User())
            ->setEmail('user2@user.fr')
            ->setUsername('moderator')
            ->setPassword($pwd)
            ->setRoles(['ROLE_USER'])
            ->setIsVerify(true)
        ;
        $manager->persist($object);


        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setUsername('admin')
            ->setPassword($pwd)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerify(true)
        ;
        $manager->persist($object);

        for ($nbUser=0; $nbUser < 10; $nbUser++) { 
            $object = (new User())
                ->setEmail($faker->email)
                ->setUsername($faker->userName)
                ->setPassword($pwd)
                ->setRoles($faker->randomElements($roles, 1))
                ->setIsVerify($faker->boolean)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
