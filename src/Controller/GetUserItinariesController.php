<?php

namespace App\Controller;

use App\Repository\UserItinaryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class GetUserItinariesController extends AbstractController
{
    public function __invoke(UserItinaryRepository $userItinaryRepository, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        //$user = $this->getUserItinary();// TEMPORAIRE
        $user = $userRepository->findAll()[0];  // TEMPORAIRE
        $json = $serializer->normalize(
            $userItinaryRepository->findBy(['userCreator' => $user]),
            null,
            ['groups'=>'itinary:read']
        );

        return $this->json($json);

    }
}