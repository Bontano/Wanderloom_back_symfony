<?php

namespace App\Controller;

use App\Entity\Itinary;
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
    )
    {
    }
    public function __invoke($id): Response
    {
        dd($id);

    }
}