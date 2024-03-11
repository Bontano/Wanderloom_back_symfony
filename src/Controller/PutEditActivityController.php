<?php

namespace App\Controller;

use App\Entity\Itinary;
use App\Repository\ActivityRepository;
use App\Repository\UserRepository;
use App\Service\ItinaryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PutEditActivityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $em

    )
    {
    }
    public function __invoke($id, ActivityRepository $activityRepository,Request $request): Response
    {
        $activity = $activityRepository->find($id);
        $content = json_decode($request->getContent());
        if (!$content->description || !$content->title ) {
            return new Response(
                "Il manque des informations pour générer l'itinéraire"
                , 400);
        }
        if (!$activity ) {
            return new Response(
                "Activité introuvable"
                , 400);
        }
        $activity->setTitle($content->title);
        $activity->setDescription($content->description);
        $this->em->remove($activity);
        $this->em->flush();

        return new Response(
            json_encode($activity)
            , 200);

    }
}