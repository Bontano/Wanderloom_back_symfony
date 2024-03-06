<?php

namespace App\Tests\Entity;

use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ItinaryAPITest extends TestCase
{
    public function testTitle()
    {
        $itinary = new Itinary();
        $title = "Vacation in France";

        $itinary->setTitle($title);
        $this->assertEquals($title, $itinary->getTitle());
    }

    public function testCountry()
    {
        $itinary = new Itinary();
        $country = "France";

        $itinary->setCountry($country);
        $this->assertEquals($country, $itinary->getCountry());
    }

    public function testFavorite()
    {
        $itinary = new Itinary();
        $favorite = true;

        $itinary->setFavorite($favorite);
        $this->assertEquals($favorite, $itinary->isFavorite());
    }

    public function testAddRemoveItinaryActivity()
    {
        $itinary = new Itinary();
        $itinaryActivity = new ItinaryActivity();

        $itinary->addItinaryActivity($itinaryActivity);
        $this->assertCount(1, $itinary->getItinaryActivities());
        $this->assertTrue($itinary->getItinaryActivities()->contains($itinaryActivity));

        $itinary->removeItinaryActivity($itinaryActivity);
        $this->assertCount(0, $itinary->getItinaryActivities());
        $this->assertFalse($itinary->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testUserRelation()
    {
        $itinary = new Itinary();
        $user = new User();


        $itinary->setUser($user);
        $this->assertEquals($user, $itinary->getUser());
    }

}