<?php

namespace App\Tests\Unitaires;

use PHPUnit\Framework\TestCase;
use Predis\Client;
use Symfony\Component\HttpFoundation\RequestStack;

class FailLoginSuscriberTest extends TestCase
{
    private $redis;

    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->getMockBuilder(RequestStack::class)
                            ->setMethods(['getCurrentRequest'])
                            ->getMock()
                            ;
        $this->redis = $this->getMockBuilder(Client::class)
                            ->disableOriginalConstructor()
                            ->getMock()
                            ;
    }

    public function test_on_authentication_failure()
    {
        $email = 'irondev@gmail.com';

        $key = 'login_failure_'.$email;

        $compteur = $this->redis->incr($key);

        $this->assertEquals(null, $compteur);

        $this->assertLessThan(1, $compteur);
    }
}
