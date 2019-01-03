<?php

use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class addUserToLDAPTest extends WebTestCase
{
    private $adapter;
    private $ldap;
    private $host;
    private $port;
    private $dn;
    private $password;
    private $attributes = ['cn', 'sn', 'uid', 'description'];

    public function __construct()
    {
        parent::__construct();
        $this->host = 'ldap.agopreneur.fr';
        $this->port = 389;
        $this->dn = 'cn=admin,dc=ldap,dc=agopreneur,dc=fr';
        $this->password = 'nimdaLDAP_1';

    }

    public function testAddUserToLDAPQuery()
    {
        $this->adapter = new Adapter(['host'=>$this->host,'port'=>$this->port]);
        $this->adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);

        $this->ldap = new Ldap($this->adapter);

        $this->ldap->bind($this->dn, $this->password);

        $filter = 'objectClass=*';

        $query = $this->ldap->query($this->dn, 'objectClass=*', ['filter' => $this->attributes]);
        $collection = $query->execute();

        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');





    }
}