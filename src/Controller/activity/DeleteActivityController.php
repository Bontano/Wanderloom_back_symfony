<?php

namespace App\Controller\activity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

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

        $this->em->remove($activity->getItinaryActivities()[0]);
        $this->em->remove($activity);
        $this->em->flush();

        return new Response(
            json_encode(true)
            , 200);

    }
}