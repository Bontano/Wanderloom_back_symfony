<?php

namespace App\Controller\itinary;

use App\Controller\app\SecurityController;
use App\Repository\UserRepository;
use App\Service\IaGenerationHandler;
use App\Service\ItinaryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PostItinaryController extends AbstractController
{

    public function __construct(
        private readonly Security $security,
    )
    {
    }

    public function __invoke(Request $request,IaGenerationHandler $iaGenerationHandler, ItinaryHandler $itinaryHandler, SecurityController $securityController, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $content = json_decode($request->getContent());
        $user = $this->security->getUser();
        if (!$content->city || !$content->startDate || !$content->endDate) {
            return new Response(
                "Il manque des informations pour générer l'itinéraire"
                , 400);
        }
        $generatedItinary = $iaGenerationHandler->newItinaryGenerator($content->startDate,$content->endDate,$content->city);

        $itinary = $itinaryHandler->makeItinaryInstance($generatedItinary, $user);
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