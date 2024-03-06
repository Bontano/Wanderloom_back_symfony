<?php

namespace App\Tests;

use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ItinaryTest extends TestCase
{

    public function testGetId()
    {
        $itinary = new Itinary();
        static::assertNull($itinary->getId());
    }

    public function testGetTitle()
    {
        $itinary = new Itinary();
        $itinary->setTitle('Test Itinary');
        static::assertEquals('Test Itinary', $itinary->getTitle());
    }

    public function testGetCountry()
    {
        $itinary = new Itinary();
        $itinary->setCountry('Test Country');
        static::assertEquals('Test Country', $itinary->getCountry());
    }

    public function testGetItinaryActivities()
    {
        $itinary = new Itinary();
        $itinaryActivity = new ItinaryActivity();
        $itinary->addItinaryActivity($itinaryActivity);
        static::assertTrue($itinary->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testAddItinaryActivity()
    {
        $itinary = new Itinary();
        $itinaryActivity = new ItinaryActivity();
        $itinary->addItinaryActivity($itinaryActivity);
        static::assertTrue($itinary->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testRemoveItinaryActivity()
    {
        $itinary = new Itinary();
        $itinaryActivity = new ItinaryActivity();
        $itinary->addItinaryActivity($itinaryActivity);
        $itinary->removeItinaryActivity($itinaryActivity);
        static::assertFalse($itinary->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testGetUser()
    {
        $itinary = new Itinary();
        $user = new User();
        $itinary->setUser($user);
        static::assertEquals($user, $itinary->getUser());
    }

    public function testIsFavorite()
    {
        $itinary = new Itinary();
        $itinary->setFavorite(true);
        static::assertTrue($itinary->isFavorite());
    }

    public function testSetFavorite()
    {
        $itinary = new Itinary();
        $itinary->setFavorite(true);
        static::assertTrue($itinary->isFavorite());
    }
}