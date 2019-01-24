<?php

namespace App\Tests\Functional;

use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Panther\PantherTestCase;

class AddInscriptionLdapTest extends PantherTestCase
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
        $this->host = 'contabo.macomnumerique.com';
        $this->port = 389;
        $this->dn = 'cn=admin,dc=contabo,dc=macomnumerique,dc=com';
        $this->password = 'nimdaLDAP_1';

    }

/*************************
* Ici commence les tests *
**************************/

    /***********************************************************************
     * Test pour vérifier si la connexion au server LDAP est fonctionnelle *
     ***********************************************************************/
    public function testConnexionLdap(){

        $this->adapter = new Adapter(['host'=>$this->host,'port'=>$this->port]);
        $this->adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);
        $this->adapter->getConnection()->setOption('REFERRALS', 0);

        $this->ldap = new Ldap($this->adapter);

        $this->ldap->bind($this->dn, $this->password);




    }


    /*************************************************************************
     * Test pour vérifier si la requête des salles dans le LDAP est possible *
     *************************************************************************/
    public function testRoomsQuery(){

        $this->adapter = new Adapter(['host'=>$this->host,'port'=>$this->port]);
        $this->adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);
        $this->adapter->getConnection()->setOption('REFERRALS', 0);

        $this->ldap = new Ldap($this->adapter);

        $this->ldap->bind($this->dn, $this->password);




    }

    /********************************************************************
     * Test pour vérifier si l'enregistrement en BdD Mysql est correcte *
     ********************************************************************/
    public function testCreateMysql()
    {
        $this->adapter = new Adapter(['host'=>$this->host,'port'=>$this->port]);
        $this->adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);
        $this->adapter->getConnection()->setOption('REFERRALS', 0);

        $this->ldap = new Ldap($this->adapter);

        $this->ldap->bind($this->dn, $this->password);

        $filter = 'objectClass=*';

        $query = $this->ldap->query($this->dn, 'objectClass=*', ['filter' => $this->attributes]);
        $collection = $query->execute();

        $client = static::createClient();
        $crawler = $client->request('GET', '/inscription');


    }



    /********************************************************************************************
     * Test pour vérifier que la page de "réussite" de la transaction d'inscription s'affichage *
     ********************************************************************************************/
    public function testAfficheInscriptionLdap()
    {
        $this->adapter = new Adapter(['host' => $this->host, 'port' => $this->port]);
        $this->adapter->getConnection()->setOption('PROTOCOL_VERSION', 3);
        $this->adapter->getConnection()->setOption('REFERRALS', 0);

        $this->ldap = new Ldap($this->adapter);

        $this->ldap->bind($this->dn, $this->password);

    }


}
