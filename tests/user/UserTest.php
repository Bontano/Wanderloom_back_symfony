<?php

namespace App\Tests;

use App\Entity\Itinary;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetId()
    {
        $user = new User();
        static::assertNull($user->getId());
    }

    public function testGetEmail()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        static::assertEquals('test@example.com', $user->getEmail());
    }

    public function testGetRoles()
    {
        $user = new User();
        $roles = ['ROLE_USER'];
        $user->setRoles($roles);
        static::assertEquals($roles, $user->getRoles());
    }

    public function testGetPassword()
    {
        $user = new User();
        $user->setPassword('password');
        static::assertEquals('password', $user->getPassword());
    }

    public function testGetUsername()
    {
        $user = new User();
        $user->setUsername('testuser');
        static::assertEquals('testuser', $user->getUsername());
    }

    public function testGetItinaries()
    {
        $user = new User();
        $itinary = new Itinary();
        $user->addItinary($itinary);
        static::assertTrue($user->getItinaries()->contains($itinary));
    }

    public function testAddItinary()
    {
        $user = new User();
        $itinary = new Itinary();
        $user->addItinary($itinary);
        static::assertTrue($user->getItinaries()->contains($itinary));
    }

    public function testRemoveItinary()
    {
        $user = new User();
        $itinary = new Itinary();
        $user->addItinary($itinary);
        $user->removeItinary($itinary);
        static::assertFalse($user->getItinaries()->contains($itinary));
    }
}