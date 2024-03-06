<?php

namespace App\Tests;

use App\Entity\Activity;
use App\Entity\Itinary;
use App\Entity\ItinaryActivity;
use PHPUnit\Framework\TestCase;

class ItinaryActivityTest extends TestCase
{

    public function testGetId()
    {
        $itinaryActivity = new ItinaryActivity();
        static::assertNull($itinaryActivity->getId());
    }

    public function testGetActivity()
    {
        $itinaryActivity = new ItinaryActivity();
        $activity = new Activity();
        $itinaryActivity->setActivity($activity);
        static::assertEquals($activity, $itinaryActivity->getActivity());
    }

    public function testSetActivity()
    {
        $itinaryActivity = new ItinaryActivity();
        $activity = new Activity();
        $itinaryActivity->setActivity($activity);
        static::assertEquals($activity, $itinaryActivity->getActivity());
    }

    public function testGetItinary()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinary = new Itinary();
        $itinaryActivity->setItinary($itinary);
        static::assertEquals($itinary, $itinaryActivity->getItinary());
    }

    public function testSetItinary()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinary = new Itinary();
        $itinaryActivity->setItinary($itinary);
        static::assertEquals($itinary, $itinaryActivity->getItinary());
    }

    public function testGetDayMoment()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinaryActivity->setDayMoment('Test Moment');
        static::assertEquals('Test Moment', $itinaryActivity->getDayMoment());
    }

    public function testSetDayMoment()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinaryActivity->setDayMoment('Test Moment');
        static::assertEquals('Test Moment', $itinaryActivity->getDayMoment());
    }

    public function testGetDay()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinaryActivity->setDay('Test Day');
        static::assertEquals('Test Day', $itinaryActivity->getDay());
    }

    public function testSetDay()
    {
        $itinaryActivity = new ItinaryActivity();
        $itinaryActivity->setDay('Test Day');
        static::assertEquals('Test Day', $itinaryActivity->getDay());
    }
}
