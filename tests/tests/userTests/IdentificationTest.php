<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 21/12/2018
 * Time: 10:15
 */

namespace App\Tests\userTests;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IdentificationTest extends KernelTestCase
{

    public function testAUserIsConnectedInAnonymous()
    {
        $user = new User();

        $this->assertEquals('anonymous', $user->getStatus());
    }

}


