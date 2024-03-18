<?php

namespace App\Controller\activity;

use App\Controller\app\SecurityController;
use App\Repository\UserRepository;
use App\Service\IaGenerationHandler;
use App\Service\ItinaryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PostNewActivityController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }
    // invoke est une fonction executé automatiquement lors de l'utilisation de cette classe
    public function __invoke(Request $request,IaGenerationHandler $iaGenerationHandler, ItinaryHandler $itinaryHandler, SecurityController $securityController, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        // Récupération de l'utilisateur connecté grâce au jwt token et au bundle security de symfony
        $user = $this->security->getUser();
        // Récupération de la charge utile de la requete (body) on prend soin de decoder le json pour le récupérer sous
        // forme de tableau associatif
        $content = json_decode($request->getContent());
        // Vérification de si les 3 champs obligatoire ont été renseignés
        if (!$content->date || !$content->dayMoment || !$content->location) {
            // Si ce n'est pas le cas on retourne une erreur
            return new Response(
                "Il manque des informations afin de générer une activité."
                , 400);
        }
        // On set à cette variable la valeur du champ optionnel. Si il est undefined, on lui ajoute la valeur null
        $AdditionalContent = isset($content->options) ?: null;
        // On envoie à la fonction de notre handler les valeurs, on stock le return de cette fonction dans la variable
        $json = $iaGenerationHandler->newActivityGenerator($content->date,$content->location,$content->dayMoment, $AdditionalContent);
        // On retourne la réponse de chatgpt à notre front
        return new Response(
            json_encode($json)
            , 200);
    }
}