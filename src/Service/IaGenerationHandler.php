<?php

namespace App\Service;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Repository\ActivityRepository;
use App\Repository\ItinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IaGenerationHandler
{
    private $apiKey;

    public function __construct(private readonly HttpClientInterface $client, private readonly EntityManagerInterface $em, private readonly ActivityRepository $activityRepository, ParameterBagInterface $params)
    {
        $this->apiKey = $params->get('OPEN_API_KEY');
    }

    public function newItinaryGenerator($startDate, $endDate, $location)
    {
        $formatedPrompt = "Crées moi un itinéraire touristique avec des activités et des description en français pour " . $location . " chaque jour entre le " . $startDate . " et le " . $endDate . ".
        Retournes moi un itinéraire sous forme de Json. Je veux uniquement une architecture de ce type là : 
        {
            `".$location."`: {
                `dd/mm/yyyy`: {
                    `morning`: {
                        title: *activity title*,
                        description: *activity description*,
                        `GPS coordinates`: {`longitude`: *longitude coordinate*, `latitude`: *latitude coordinate},
                    },
                    `afternoon`: {
                        title: *activity title*,
                        description: *activity description*,
                        `GPS coordinates`: {`longitude`: *longitude coordinate*, `latitude`: *latitude coordinate},   
                    },
                    `evening`: {
                        title: *activity title*,
                        description: *activity description*,
                        `GPS coordinates`: {`longitude`: *longitude coordinate*, `latitude`: *latitude coordinate},  
                    },
                }
            }
        }
        Je veux que tu me retourne uniquement le json sans texte superflu. Les coordonnées doivent être très précises";
        return $this->iaFetcher($formatedPrompt);
    }

    public function newActivityGenerator($date, $dayMoment, $location, $option = null)
    {
        $formatedPrompt = "Crées moi une activité touristique en français pour $location à faire le $date à ce moment de la journée : $dayMoment.
        Retournes moi une activité sous forme de Json. Je veux uniquement une architecture de ce type là : 
        {
            title: *activity title*,
            description: *activity description*,
            `GPS coordinates`: {`longitude`: *longitude coordinate*, `latitude`: *latitude coordinate},
         }";
        return $this->iaFetcher($formatedPrompt);
    }

    public function iaFetcher($prompt)
    {
        try {
            $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => $this->apiKey,
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                ],
            ]);
            return json_decode(json_decode($response->getContent())->choices[0]->message->content);
        } catch (GuzzleException $e) {
            return $e;
        }
    }
}