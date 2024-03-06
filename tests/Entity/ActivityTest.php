<?php

namespace App\Tests\Entity;

use App\Entity\Activity;
use App\Entity\ItinaryActivity;
use PHPUnit\Framework\TestCase;

class ActivityTest extends testCase
{
    public function testDescription()
    {
        $activity = new Activity();
        $description = "Test Description";

        $activity->setDescription($description);
        $this->assertEquals($description, $activity->getDescription());
    }

    public function testCountry()
    {
        $activity = new Activity();
        $country = "France";

        $activity->setCountry($country);
        $this->assertEquals($country, $activity->getCountry());
    }

    public function testAddRemoveItinaryActivity()
    {
        $activity = new Activity();
        $itinaryActivity = new ItinaryActivity();

        $activity->addItinaryActivity($itinaryActivity);
        $this->assertCount(1, $activity->getItinaryActivities());
        $this->assertTrue($activity->getItinaryActivities()->contains($itinaryActivity));

        $activity->removeItinaryActivity($itinaryActivity);
        $this->assertCount(0, $activity->getItinaryActivities());
        $this->assertFalse($activity->getItinaryActivities()->contains($itinaryActivity));
    }

}