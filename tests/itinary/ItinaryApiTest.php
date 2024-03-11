<?php

namespace App\Tests\itinary;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ItinaryApiTest extends WebTestCase
{
    public function testAddItinary(): void
    {
        $client = new Client(['verify' => false]);

        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $jwtManager = self::getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail('john-doe@gmail.com');
        $user->setPassword($hasher->hashPassword($user,'azerty'));
        $entityManager->persist($user);



        $itinary = new Itinary();
        $itinary->setUser($user);
        $itinary->setTitle("Mon itinéraire en france");
        $itinary->setCountry("france");
        $itinary->setFavorite(true);
        $entityManager->persist($itinary);
        $activity = new Activity();
        $activity->setCountry("france");
        $activity->setTitle('La plage');
        $activity->setDescription('Visite de la pointe rouge');
        $activity->setLongitude(1);
        $activity->setLatitude(1);
        $entityManager->persist($activity);
        $itinaryActivity = new ItinaryActivity();
        $itinaryActivity->setItinary($itinary);
        $itinaryActivity->setActivity($activity);
        $itinaryActivity->setDay('Jour 1');
        $itinaryActivity->setDayMoment('matin');
        $entityManager->persist($itinaryActivity);

        $secondItinary = new Itinary();
        $secondItinary->setUser($user);
        $secondItinary->setTitle("Mon itinéraire en allemagne");
        $secondItinary->setCountry("allemagne");
        $secondItinary->setFavorite(false);
        $entityManager->persist($secondItinary);
        $secondActivity = new Activity();
        $secondActivity->setCountry("allemagne");
        $secondActivity->setTitle('Visite de la capitale');
        $secondActivity->setLongitude(1);
        $secondActivity->setLatitude(1);
        $secondActivity->setDescription('Visite de berlin');
        $entityManager->persist($secondActivity);
        $secondItinaryActivity = new ItinaryActivity();
        $secondItinaryActivity->setItinary($secondItinary);
        $secondItinaryActivity->setActivity($secondActivity);
        $secondItinaryActivity->setDay('Jour 1');
        $secondItinaryActivity->setDayMoment('matin');
        $entityManager->persist($itinaryActivity);
        $entityManager->flush();
        $token = $jwtManager->create($user);
        $response = $client->request('GET', 'http://localhost:8000/api/itinary/user', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/ld+json',
                'Accept' => 'application/ld+json',
            ],
            'query' => [
                'type' => 'favorites',
            ],
        ]);


        $body = json_decode($response->getBody()->getContents());
        $this->assertSame(1, count($body));
    }
}