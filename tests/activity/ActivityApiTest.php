<?php

namespace App\Tests\activity;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Entity\User;
use App\Repository\ActivityRepository;
use App\Service\IaGenerationHandler;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ActivityApiTest extends WebTestCase
{
    public function testGenerateActivity(): void
    {
        $client = new Client(['verify' => false]);

        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $jwtManager = self::getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
        $iaGenerationHandler = self::getContainer()->get(IaGenerationHandler::class);

        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail('john-doe@gmail.com');
        $user->setPassword($hasher->hashPassword($user,'azerty'));
        $entityManager->persist($user);
        $entityManager->flush();
        $token = $jwtManager->create($user);
        $response = $client->request('POST', 'http://localhost:8000/api/activity/generate', [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'date' => '10/12/2024',
                'location' => 'Berlin',
                'dayMoment' => 'Midi',
                'options' => 'un restaurant gastronomique',
            ],
        ]);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testEditActivity(): void
    {
        $client = new Client(['verify' => false]);

        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $jwtManager = self::getContainer()->get('lexik_jwt_authentication.jwt_manager');
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
        $activityRepository = self::getContainer()->get(ActivityRepository::class);

        $user = new User();
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setEmail('janne-doe@gmail.com');
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
        $entityManager->flush();
        $token = $jwtManager->create($user);
        $activityId = $activity->getId();
        $patchResponse = $client->request('PATCH', "http://localhost:8000/api/activities/$activityId", [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'description' => 'Déjeuner au bord du lac de sainte croix, avec un panorama à couper le souffle.',
                'title' => 'Déjeuner au bord du lac',
            ],
        ]);
        $this->assertSame(200, $patchResponse->getStatusCode());
        $modifiedActivity = $activityRepository->findBy(["title" => 'Déjeuner au bord du lac']);
        $this->assertSame(1, count($modifiedActivity));

        $deleteResponse = $client->request('DELETE', "http://localhost:8000/api/activity/$activityId/delete", [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/ld+json',
            ],
        ]);
        $this->assertSame(200, $deleteResponse->getStatusCode());
        $deleteActivity = $activityRepository->find($activityId);
        dd($deleteActivity);
        $this->assertSame($deleteActivity, 'true');
    }
}