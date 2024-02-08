<?php

namespace App\Controller;

use App\Service\ItinaryHandler;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ItineraireController extends AbstractController
{

    public function __invoke(Request $request, ItinaryHandler $itinaryHandler): Response
    {
        $content = json_decode($request->getContent());
        if(!$content->city || !$content->startDate || !$content->endDate) {
            return new Response(
                "Il manque des informations pour générer l'itinéraire"
                , 400);
        }
        $firstPromptSubstring = "Crées moi un itinéraire touristique pour";
        $city = str_replace(' ','_',$content->city);
        $secondPromptSubstring = "entre le";
        $startDate = $content->startDate;
        $thirdPromptSubstring = "et le";
        $endDate = $content->endDate;
        $fourthPromptSubstring = "Retournes moi un itinéraire sous forme de Json. Je veux que une architecture de ce type là : 
        ->ville->semaine->jour->moment de la journée.
        Je veux que tu me retourne uniquement le json sans texte superflu";
        $prompt = $firstPromptSubstring ." ". $city ." ". $secondPromptSubstring ." ". $startDate ." ". $thirdPromptSubstring ." ". $endDate ." ". $fourthPromptSubstring;
        $itinary = $itinaryHandler->genererItineraire($prompt);
        dd(json_decode($itinary) );
        return new Response(
            $itinary
            , 200);
    }

}