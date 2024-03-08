<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ItinaryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PostItinaryController extends AbstractController
{

    public function __invoke(Request $request, ItinaryHandler $itinaryHandler, SecurityController $securityController, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $content = json_decode($request->getContent());
        $user = $userRepository->findAll()[0];
        //$user = $securityController->getUser();
        if (!$content->city || !$content->startDate || !$content->endDate) {
            return new Response(
                "Il manque des informations pour générer l'itinéraire"
                , 400);
        }
        $firstPromptSubstring = "Crées moi un itinéraire touristique pour";
        $city = str_replace(' ', '_', $content->city);
        $secondPromptSubstring = "entre le";
        $startDate = $content->startDate;
        $thirdPromptSubstring = "et le";
        $endDate = $content->endDate;
        $fourthPromptSubstring = "Retournes moi un itinéraire sous forme de Json. Je veux uniquement une architecture de ce type là : 
        ->ville->semaine->jour->moment de la journée.
        Je veux que tu me retourne uniquement le json sans texte superflu";
        $prompt = $firstPromptSubstring . " " . $city . " " . $secondPromptSubstring . " " . $startDate . " " . $thirdPromptSubstring . " " . $endDate . " " . $fourthPromptSubstring;
        // Ligne pour utiliser le mock
        $itinary = $itinaryHandler->generatorItineraryMock($prompt, $user);
        // Ligne pour utiliser chatgpt
        // $itinary = $itinaryHandler->genererItineraireOpenAi($prompt, $user);
        $json = $serializer->normalize(
            $itinary,
            null,
            ['groups'=>'itinary:read']
        );
        return new Response(
            json_encode($json)
            , 200);
    }

}