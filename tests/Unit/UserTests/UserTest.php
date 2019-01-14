<?php

namespace App\Tests\Unit\UserTests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIfISetTheUserRole()
    {
        $user = new User();
        $user->setRoles("ROLE_COBAYE");

        $this->assertEquals($user->getRoles(), ["ROLE_COBAYE"]);
    }

    public function test_user_id_employ_must_be_integer()
    {
        $user = new User();
        $user->setIdEmploy("1234h6");

        $this->assertEquals("1234h6", $user->getIdEmploy());
    }
}