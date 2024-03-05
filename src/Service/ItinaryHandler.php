<?php

namespace App\Service;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Repository\ActivityRepository;
use App\Repository\ItinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ItinaryHandler
{

    public function __construct(private readonly HttpClientInterface $client, private readonly EntityManagerInterface $em, private readonly ActivityRepository $activityRepository, private readonly ItinaryRepository $itinaryRepository)
    {
    }

    public function genererItineraireMock(string $prompt, $user): Itinary
    {
        try {
            $response = $this->client->request('POST', 'http://141.95.175.158:3010/itineraire', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    "prompt" => $prompt,
                ]),
            ]);
            return
                self::setInDatabase((array)json_decode($response->getContent()), $user);
        } catch (GuzzleException $e) {
            return $e;
        }
    }
    public function genererItineraireOpenAi(string $prompt, $user)
    {
        try {
            $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization'=>'Bearer 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',
                    'OpenAI-Organization'=> 'org-ppbI1onTjUKtzlo4HNOTH9iq'
                ],
                'body' => json_encode([
                    'prompt' => $prompt,
                    'model' => 'gpt-3.5-turbo',
                    "temperature"=> 0.7,
                ]),
            ]);
            return $response;
            return
                self::setInDatabase((array)json_decode($response->getContent()), $user);
        } catch (GuzzleException $e) {
            return $e;
        }
    }
    public function setInDatabase($itinaryDatas, $user): Itinary
    {
        $itinary = new Itinary();
        $itinary->setCountry(array_key_first($itinaryDatas));
        $itinary->setTitle("Mon bel itinéraire");
        $itinary->setFavorite(false);
        $itinary->setUser($user);
        $index = 0;
        foreach ($itinaryDatas[array_key_first($itinaryDatas)] as $day) {
            $index++;
            foreach ($day as $dayMoment => $activities)
                foreach ($activities as $activityContent) {
                    if ($this->activityRepository->findOneBy(['description' => $activityContent]) === null) {
                        $activity = new Activity();
                        $activity->setDescription($activityContent);
                        $activity->setCountry(array_key_first($itinaryDatas));
                        $this->em->persist($activity);

                        $activityInItinary = new ItinaryActivity();
                        $activityInItinary->setActivity($activity);
                        $activityInItinary->setItinary($itinary);
                        $activityInItinary->setDay($index);
                        $activityInItinary->setDayMoment($dayMoment);
                        $this->em->persist($activityInItinary);
                    } else {
                        $activity = $this->activityRepository->findOneBy(['description' => $activityContent]);
                        $activityInItinary = new ItinaryActivity();
                        $activityInItinary->setActivity($activity);
                        $activityInItinary->setItinary($itinary);
                        $activityInItinary->setDay($index);
                        $activityInItinary->setDayMoment($dayMoment);
                        $this->em->persist($activityInItinary);
                    }
                }
        }
        $this->em->flush();
        return $itinary;
    }
}