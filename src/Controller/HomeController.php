<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="booking.home")
     */
    public function home()
    {
        $adapter = new Adapter(['host'=>'ldap.agopreneur.fr', 'port'=>389]);
        $adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);

        $ldap = new Ldap($adapter);

        $ldap->bind('cn=admin,dc=ldap,dc=agopreneur,dc=fr', 'nimdaLDAP_1');

        $entry = new Entry('cn=ROLE_ANONYMOUS,ou=UTILISATEURS,dc=ldap,dc=agopreneur,dc=fr', [
            'cn' => 'ROLE_ANONYMOUS',
            'objectClass' => ['posixGroup','top'],
            'gidNumber' => 513
        ]);

        $entryManager = $ldap->getEntryManager();
        $entryManager->add($entry);

        $query=$ldap->query('dc=ldap,dc=agopreneur,dc=fr', '(&(objectclass=*))');
        $result = $query->execute();

        $entry = $result[1];
        dump($entry);
        dump($result);

        return $this->render('booking/home.html.twig');
    }
}