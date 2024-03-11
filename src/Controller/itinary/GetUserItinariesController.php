<?php

namespace App\Controller\itinary;

use App\Repository\ItinaryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetUserItinariesController extends AbstractController
{

    public function __construct(
        private readonly Security $security,
    )
    {
    }
    public function __invoke(ItinaryRepository $itinaryRepository, UserRepository $userRepository, SerializerInterface $serializer, Request $request): Response
    {

        $user = $this->security->getUser();
        if ($type = $request->query->get('type')){
            if ($type === "favorites"){
                $data = $itinaryRepository->findBy(['user' => $user, 'favorite'=>true]);
            }else{
                $data = $itinaryRepository->findBy(['user' => $user, 'favorite'=>false]);
            }
        }else{
            $data = $itinaryRepository->findBy(['user' => $user]);
        }

        $json = $serializer->normalize(
            $data,
            null,
            ['groups'=>'itinary:read']
        );

        return $this->json($json);

    }
}