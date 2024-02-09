<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
for ($i=0; $i<10; $i++){
    $user = new User();
    $user->setEmail($faker->email());
    $user->setUsername($faker->userName());
    $user->setPassword($faker->password());
    $user->setRoles(["ROLE_USER"]);
    $manager->persist($user);

}

        $manager->flush();

    }
}
