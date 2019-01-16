<?php

namespace App\Controller;


use Adldap\Adldap;
use Adldap\Auth\BindException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * @Route("/ldap-test", name="ldap.test")
     */
    public function testLdap()
    {
        // Construct new Adldap instance.
        $ad = new Adldap();

        $config = [
            'hosts'    => ['ldap.agopreneur.fr'],
            'base_dn'  => 'dc=ldap,dc=agopreneur,dc=fr',
            'username' => 'cn=admin,dc=ldap,dc=agopreneur,dc=fr',
            'password' => 'nimdaLDAP_1',
            'port'             => 389,
            'follow_referrals' => false,
            'use_ssl'          => true,
            'use_tls'          => false,
            'version'          => 3,
        ];

        // Add a connection provider to Adldap.
        $ad->addProvider($config);

        try {
            // If a successful connection is made to your server, the provider will be returned.
            $provider = $ad->connect();
            dump($provider);

            // Creating a new LDAP entry. You can pass in attributes into the make methods.
            $user =  $provider->make()->user();

            $user->setCommonName('John Doe3');
            $user->setPassword("test");
            $user->setLastName("Doe3");
            $user->setFirstName("John");
            $user->setHomeDirectory('/home/users/jo');
            $user->setEmail("jojo@gmail.com");

            // Saving the changes to your LDAP server.
            if ($user->save()) {

                $this->addFlash("success", "user created");

            }

        } catch (BindException $e) {

            dump($e);

        }

        return $this->render("test/ldap-test.html.twig");
    }
}