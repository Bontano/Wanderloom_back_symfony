<?php

namespace App\Controller;

use App\Entity\Itinary;
use App\Repository\UserRepository;
use App\Service\ItinaryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutFavoriteItinaryController extends AbstractController
{
    public function __invoke(Request $request, Itinary $itinary, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $content = json_decode($request->getContent());
        $user = $userRepository->findAll()[0]; //TEMPORAIRE
        $itinary->setFavorite(!$itinary->isFavorite());
        $em->persist($itinary);
        $em->flush($itinary);






        return new Response(
            json_encode($itinary)
            , 200);
    }
}