<?php

namespace App\Controller;

use App\Entity\Itinary;
use App\Repository\UserRepository;
use App\Service\ItinaryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutFavoriteItinaryController extends AbstractController
{
    public function __invoke(Request $request, Itinary $itinary, UserRepository $userRepository): Response
    {
        $content = json_decode($request->getContent());
        $user = $userRepository->findAll()[0]; //TEMPORAIRE

        $itinary->getUserCreator()->setFavorite(!$itinary->getUserCreator()->isFavorite());





        return new Response(
            json_encode($itinary)
            , 200);
    }
}