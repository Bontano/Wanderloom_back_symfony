<?php

namespace App\Controller;

use App\Entity\Itinary;
use App\Repository\UserRepository;
use App\Service\IaGenerationHandler;
use App\Service\ItinaryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PostNewActivityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }
    public function __invoke(Request $request,IaGenerationHandler $iaGenerationHandler, ItinaryHandler $itinaryHandler, SecurityController $securityController, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        $user = $this->security->getUser();
        $content = json_decode($request->getContent());
        if (!$content->date || !$content->startDate || !$content->endDate) {
            return new Response(
                "Il manque des informations pour générer l'itinéraire"
                , 400);
        }
        $json = $iaGenerationHandler->newActivityGenerator($content->date,$content->location,$content->dayMoment, $content->options);
        return new Response(
            json_encode($json)
            , 200);
    }
}