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
        /*$adapter = new Adapter(['host'=>'149.91.82.117', 'port'=>389]);

        $adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);

        $ldap = new Ldap($adapter);

        $ldap->bind('cn=admin,dc=ldap,dc=agopreneur,dc=fr', 'nimdaLDAP_1');

        $entry = new Entry("cn=test3,dc=ldap,dc=agopreneur,dc=fr", [
            'objectClass'   => ['inetOrgPerson', 'posixAccount'],
            'cn'            => 'firstname lastname',
            'sn'            => 'lastname',
            'uid'           => 'flastname',
            'displayName'   => 'test',
            'givenName'     => 'firstname',
            'mail'          => 'test@gmail.com',
            'gidNumber'     => 505,
            'uidNumber'     => 1004,
            'homeDirectory' => '/home/users/flastname',
            'loginShell'    => '/bin/sh',
            'userPassword'  => md5('test')
        ]);

        $entryManager = $ldap->getEntryManager();

        $entryManager->add($entry);

        $options["filter"][0] = "(&(sn=eric))";

        $results = $ldap->query('dc=ldap,dc=agopreneur,dc=fr', '(&(objectclass=posixAccount))', $options);
        $dt = $results->execute();


        dump($results->execute(), $dt->toArray());
        die();

        $this->assertEquals('anonymous', $user->getStatus());
        */
    }

}


