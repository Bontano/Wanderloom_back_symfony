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

class PutFavoriteItinaryController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }
    public function __invoke(Request $request, Itinary $itinary, SerializerInterface $serializer, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $user = $this->security->getUser();
        if ($itinary->getUser() === $user){
            $itinary->setFavorite(!$itinary->isFavorite());
            $em->persist($itinary);
            $em->flush($itinary);
        }

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