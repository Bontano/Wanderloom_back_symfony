<?php

namespace App\Tests\itinary;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Entity\User;
use GuzzleHttp\Exception\GuzzleException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class itinaryApiTest extends WebTestCase
{
    public function testAddItinary(): void
    {
        $client = static::createClient();
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $jwtManager = self::getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail('johnDoe@gmail.com');
        $user->setPassword('azerty');
        $entityManager->persist($user);

        $token = $jwtManager->create($user);


        $itinary = new Itinary();
        $itinary->setUser($user);
        $itinary->setTitle("Mon itinéraire en france");
        $itinary->setCountry("france");
        $itinary->setFavorite(false);
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

        $client->request('GET', 'https://localhost:8000/api/itinary/user', [], [], [
            'Authorization' => 'Bearer '. $token,
            'Content-Type' => 'application/ld+json',
            "Accept" => "application/ld+json"
        ]);
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), 'Le code de statut HTTP attendu n\'est pas retourné.');
        $responseData = json_decode($response->getContent(), true);
        dump($responseData);

    }
}