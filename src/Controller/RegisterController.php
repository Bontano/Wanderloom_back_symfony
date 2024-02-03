<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    public function __invoke(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent());
        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($hasher->hashPassword($user, $data->password));
        $user->setUsername($data->username);
        $user->setRoles(['ROLE_USER']);
        $em->persist($user);
        $em->flush();
dd($user);
        return $user;
    }


}