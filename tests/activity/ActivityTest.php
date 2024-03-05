<?php

namespace App\Tests;

use App\Entity\Activity;
use App\Entity\ItinaryActivity;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{

    public function testGetId()
    {
        $activity = new Activity();
        static::assertNull($activity->getId());
    }

    public function testGetDescription()
    {
        $activity = new Activity();
        $activity->setDescription('Test Description');
        static::assertEquals('Test Description', $activity->getDescription());
    }

    public function testGetCountry()
    {
        $activity = new Activity();
        $activity->setCountry('Test Country');
        static::assertEquals('Test Country', $activity->getCountry());
    }

    public function testGetItinaryActivities()
    {
        $activity = new Activity();
        $itinaryActivity = new ItinaryActivity();
        $activity->addItinaryActivity($itinaryActivity);
        static::assertTrue($activity->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testAddItinaryActivity()
    {
        $activity = new Activity();
        $itinaryActivity = new ItinaryActivity();
        $activity->addItinaryActivity($itinaryActivity);
        static::assertTrue($activity->getItinaryActivities()->contains($itinaryActivity));
    }

    public function testRemoveItinaryActivity()
    {
        $activity = new Activity();
        $itinaryActivity = new ItinaryActivity();
        $activity->addItinaryActivity($itinaryActivity);
        $activity->removeItinaryActivity($itinaryActivity);
        static::assertFalse($activity->getItinaryActivities()->contains($itinaryActivity));
    }
}