<?php

namespace App\Controller\itinary;

use App\Repository\ItinaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

class PutAddActivityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }
    public function __invoke($id, ItinaryRepository $itinaryRepository): Response
    {
        $itinary = $itinaryRepository->find($id);
        if (!$itinary){

        }

    }
}