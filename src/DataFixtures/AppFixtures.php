<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    public function __construct(readonly private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $firstUser = true;
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            if ($firstUser){
                $user->setEmail('exemple@exemple.fr');
                $user->setRoles(["ROLE_ADMIN"]);
                $firstUser = !$firstUser;
            }else{
                $user->setEmail($faker->email());
                $user->setRoles(["ROLE_USER"]);
            }
            $user->setPassword($this->hasher->hashPassword($user,'azerty'));
            $manager->persist($user);

        }
        $manager->flush();
    }
}
