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
    for( $i=0; $i < rand(0, 10); $i++){
        $itinary = new Itinary();
        $itinary->setDate(new \DateTimeImmutable());
        $itinary->setTitle($faker->title());
        $itinary->setUserCreator($user);
        $itinary->setCountry($faker->country());
        $itinary->setNote($faker->text());
        $itinary->setUser($user);
        $manager->persist($itinary);
    }
    $manager->persist($user);

}

for( $i=0; $i<10; $i++){
    $activity = new Activity();
    $activity->setDate(new \DateTimeImmutable());
    $activity->setName($faker->name());
    $activity->setDescription($faker->text());
    $activity->setType($faker->text());
    $manager->persist($activity);
}

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();

    }
}
