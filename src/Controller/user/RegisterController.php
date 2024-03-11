<?php

namespace App\Controller\user;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    public function __invoke(Request $request, UserPasswordHasherInterface $hasher, JWTTokenManagerInterface $JWTTokenManager,EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent());
        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($hasher->hashPassword($user, $data->password));
        $user->setRoles(['ROLE_USER']);
        $em->persist($user);
        $em->flush();
        return new Response($JWTTokenManager->create($user), 200);
    }


}