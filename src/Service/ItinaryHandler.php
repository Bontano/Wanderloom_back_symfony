<?php

namespace App\Service;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Repository\ActivityRepository;
use App\Repository\ItinaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function PHPUnit\Framework\throwException;

class ItinaryHandler
{
    public function __construct(private readonly EntityManagerInterface $em, ParameterBagInterface $params)
    {
    }

    public function makeItinaryInstance($itinaryArray, $user): Itinary
    {
        try {
            $itinaryArray = (array)$itinaryArray;
            //Création d'une instance d'itineraire
            $itinary = new Itinary();
            // Ajout à l'instance des informations relatives à l'itineraire
            $itinary->setTitle("Mon bel itinéraire");
            $itinary->setCountry(array_key_first($itinaryArray));
            $itinary->setFavorite(false);
            // Ajout de l'auteur
            $itinary->setUser($user);
            // Boucle sur les jours du json
            foreach ($itinaryArray[array_key_first($itinaryArray)] as $date=>$day){
                $day = (array)$day;
                // Boucle sur les moments de la journée
                foreach ($day as $dayMoment=>$dayContent){
                    $dayContent = (array)$dayContent;
                    // Création de la relation entre une activité et l'itineraire
                    $itinaryActivity = new ItinaryActivity();
                    // Ajout des informations relative à la relation
                    $itinaryActivity->setItinary($itinary);
                    $itinaryActivity->setDay($date);
                    $itinaryActivity->setDayMoment($dayMoment);
                    // Création d'une instance correspondante à l'activité
                    $activity = new Activity();
                    // Ajout à l'instance des informations relatives à l'activité
                    $activity->setCountry(array_key_first($itinaryArray));
                    $activity->setDescription($dayContent['description']);
                    $activity->setTitle($dayContent['title']);
                    $activity->setLatitude($dayContent['GPS coordinates']->latitude);
                    $activity->setLongitude($dayContent['GPS coordinates']->longitude);
                    // Ajout de l'activité à la relation
                    $itinaryActivity->setActivity($activity);
                    // Ajout de la relation à l'itineraire
                    $itinary->addItinaryActivity($itinaryActivity);
                    // Persist des instances
                    $this->em->persist($activity);
                    $this->em->persist($itinaryActivity);
                }
            }
            $this->em->persist($itinary);
            // Envoi en bdd des informations
            $this->em->flush();
            return $itinary;
        }catch(Exception){
            dd("nooooooooooooooooooooooooon");
        }
    }

}