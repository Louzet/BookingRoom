<?php

namespace App\Controller;


use Symfony\Component\Ldap\Ldap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * @Route("/ldap-test", name="ldap.test")
     */
    public function testLdap()
    {
        $dn = 'cn=admin,dc=ldap,dc=agopreneur,dc=fr';
        $password = 'nimdaLDAP_1';

        $ldap = Ldap::create('ext_ldap', [
            'host' => 'ldap.agopreneur.fr',
            'port' => 389,]);

        $ldap->bind($dn, $password);

        $query = $ldap->query('dc=ldap,dc=agopreneur,dc=fr', '(&(objectclass=simpleSecurityObject)(cn=admin))');

        $results = $query->execute();

        dump($results);



        $dn1 = 'cn=admin,dc=contabo,dc=macomnumerique,dc=com';
        $password1 = 'nimdaLDAP_1';

        $ldap1 = Ldap::create('ext_ldap', [
            'host' => 'contabo.macomnumerique.com',
            'port' => 389,]);

        $ldap1->bind($dn1, $password1);

        $query1 = $ldap1->query('dc=contabo,dc=macomnumerique,dc=com', '(&(objectclass=simpleSecurityObject)(cn=admin))');

        $results1 = $query1->execute();

        dump($results1);

        return $this->render("test/ldap-test.html.twig");
    }
}