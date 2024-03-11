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

class DeleteActivityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $em

    )
    {
    }
    public function __invoke($id, ActivityRepository $activityRepository): Response
    {
        $activity = $activityRepository->find($id);
        $activity->removeItinaryActivity($activity->getItinaryActivities()[0]);
        $this->em->remove($activity);
        $this->em->flush();

        return new Response(
            json_encode(true)
            , 200);

    }
}