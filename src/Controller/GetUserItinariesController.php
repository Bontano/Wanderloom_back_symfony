<?php

namespace App\Controller;

use App\Repository\UserItinaryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetUserItinariesController extends AbstractController
{
    public function __invoke(UserItinaryRepository $UserItinaryRepository, UserRepository $userRepository)
    {
        //$user = $this->getUserItinary();
        $user = $userRepository->findAll()[0];  // TEMPORAIRE
        return new Response(
            json_encode($UserItinaryRepository->findBy(["user" => $user, "favorite" => true]))
            , 200);
    }
}