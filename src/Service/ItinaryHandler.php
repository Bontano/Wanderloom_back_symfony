<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ItinaryHandler
{

    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    public function genererItineraire(string $prompt)
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
                $response->getContent();
        } catch (GuzzleException $e) {
            return $e;
        }
    }

}