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
            $itinary = new Itinary();
            $itinary->setTitle("Mon bel itinéraire");
            $itinary->setCountry(array_key_first($itinaryArray));
            $itinary->setFavorite(false);
            $itinary->setUser($user);
            foreach ($itinaryArray[array_key_first($itinaryArray)] as $date=>$day){
                $day = (array)$day;
                foreach ($day as $dayMoment=>$dayContent){
                    $dayContent = (array)$dayContent;
                    $itinaryActivity = new ItinaryActivity();
                    $itinaryActivity->setItinary($itinary);
                    $itinaryActivity->setDay($date);
                    $itinaryActivity->setDayMoment($dayMoment);
                    $activity = new Activity();
                    $activity->setCountry(array_key_first($itinaryArray));
                    $activity->setDescription($dayContent['description']);
                    $activity->setTitle($dayContent['title']);
                    $activity->setLatitude($dayContent['GPS coordinates']->latitude);
                    $activity->setLongitude($dayContent['GPS coordinates']->longitude);
                    $itinaryActivity->setActivity($activity);
                    $itinary->addItinaryActivity($itinaryActivity);
                    $this->em->persist($activity);
                    $this->em->persist($itinaryActivity);
                }
            }
            $this->em->persist($itinary);
            $this->em->flush();
            return $itinary;
        }catch(Exception){
            dd("nooooooooooooooooooooooooon");
        }
    }

}