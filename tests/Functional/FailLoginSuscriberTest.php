<?php

namespace App\Tests\Functional;

use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class FailLoginSuscriberTest extends PantherTestCase
{
    public function test_the_connexion_page()
    {
        $client = static::createPantherClient('127.0.0.1', 7000);

        $webDriver = $client->getWebDriver();

        $crawler = $client->request('GET', '/login');

        $this->assertContains('Connectez vous', $crawler->filter('h2')->text());
    }

    public function test_user_dont_enter_an_email()
    {
        $client = static::createPantherClient('127.0.0.1', 7000);

        $crawler = $client->request('GET', '/login');

        $crawler->form()->setValues([
            'email' => 'modo@booking.com',
            'password' => 123456,
        ]);

        $form = $crawler->selectButton('submit')->form();

        $form2 = $crawler->filter('form')->selectButton('submit');

        $this->expectException(AuthenticationFailureEvent::class);

        $client->submit($form2);
    }
}
