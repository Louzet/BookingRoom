<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestRoomController extends AbstractController
{

    /**
     * @Route("/room-test", name="room.test")
     */
    public function testRoomLdap1()
    {
        /**
         * Setup 1
         */
        $ldap_password = 'nimdaLDAP_1';
        //sldap_password = $form->get("password");
        $ldap_username = 'cn=admin,dc=ldap,dc=agopreneur,dc=fr';
        $ldap_connection = ldap_connect('ldap://ldap.agopreneur.fr:389');
        $ldaptree = "dc=ldap,dc=agopreneur,dc=fr";

        if (FALSE === $ldap_connection) {
            echo "Uh-oh, something is wrong...";
        }

        // We have to set this option for the version of Active Directory we are using.
        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.


        if ($ldap_connection) {
            // binding to ldap server
            $ldapbind = ldap_bind($ldap_connection, $ldap_username, $ldap_password) or die ("Error trying to bind: " . ldap_error($ldap_connection));

            // verify binding
            if ($ldapbind) {
                echo "LDAP bind successful...<br /><br />";

                $filter = 'objectClass=room';
                $justthese = array('dn','description');

                // pour @ldap_search voir:
                // https://www.developpez.net/forums/d861196/php/langage/fonctions/php-ldap-impossibilite-d-interroger-l-active-directory/
                // pour détails $justthese voir:
                // http://php.net/manual/fr/function.ldap-search.php
                $result = @ldap_search($ldap_connection, $ldaptree, $filter, $justthese) or die ("Error in search query: " . ldap_error($ldap_connection));

                #dump($result);

                $data = ldap_get_entries($ldap_connection, $result);
                #dump($data);

                // SHOW ALL DATA
                echo '<h1>Dump room ldap.agopreneur.fr</h1><pre>';
                print_r($data);
                echo '</pre>';

                /* iterate over array and print data for each entry
                echo '<h1>Show me the users</h1>';
                for ($i = 0; $i < $data["count"]; $i++) {
                    //echo "dn is: ". $data[$i]["dn"] ."<br />";
                    echo "User: " . $data[$i]["cn"][0] . "<br />";
                    if (isset($data[$i]["mail"][0])) {
                        echo "Email: " . $data[$i]["mail"][0] . "<br /><br />";
                    } else {
                        echo "Email: None<br /><br />";
                    }
                }
                // print number of entries found
                echo "Number of entries found: " . ldap_count_entries($ldap_connection, $result);*/
            } else {
                echo "LDAP bind failed...";
            }

        }
        // all done? clean up
        ldap_close($ldap_connection);

        /**
         * Setup 2
         */
        $ldap_password1 = 'nimdaLDAP_1';
        $ldap_username1 = 'cn=admin,dc=contabo,dc=macomnumerique,dc=com';
        $ldap_connection1 = ldap_connect('ldap://contabo.macomnumerique.com:389');
        $ldaptree1 = "dc=contabo,dc=macomnumerique,dc=com";

        if (FALSE === $ldap_connection1) {
            echo "Uh-oh, something is wrong...";
        }

        // We have to set this option for the version of Active Directory we are using.
        ldap_set_option($ldap_connection1, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap_connection1, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.


        if ($ldap_connection1) {
            // binding to ldap server
            $ldapbind1 = ldap_bind($ldap_connection1, $ldap_username1, $ldap_password1) or die ("Error trying to bind: " . ldap_error($ldap_connection));

            // verify binding
            if ($ldapbind1) {
                echo "LDAP bind successful...<br /><br />";

                $filter1 = 'objectClass=room';
                $justthese1 = array('dn','description');

                // pour @ldap_search voir:
                // https://www.developpez.net/forums/d861196/php/langage/fonctions/php-ldap-impossibilite-d-interroger-l-active-directory/
                // pour détails $justthese voir:
                // http://php.net/manual/fr/function.ldap-search.php
                $result1 = @ldap_search($ldap_connection1, $ldaptree1, $filter1, $justthese1) or die ("Error in search query: " . ldap_error($ldap_connection));

                dump($result1);

                $data1 = ldap_get_entries($ldap_connection1, $result1);
                dump($data1);

                // SHOW ALL DATA
                echo '<h1>Dump room contabo.macomnumerique.com</h1><pre>';
                print_r($data1);
                echo '</pre>';

                /* iterate over array and print data for each entry
                echo '<h1>Show me the users</h1>';
                for ($i = 0; $i < $data["count"]; $i++) {
                    //echo "dn is: ". $data[$i]["dn"] ."<br />";
                    echo "User: " . $data[$i]["cn"][0] . "<br />";
                    if (isset($data[$i]["mail"][0])) {
                        echo "Email: " . $data[$i]["mail"][0] . "<br /><br />";
                    } else {
                        echo "Email: None<br /><br />";
                    }
                }
                // print number of entries found
                echo "Number of entries found: " . ldap_count_entries($ldap_connection, $result);*/
            } else {
                echo "LDAP bind failed...";
            }

        }

        return $this->render("test/room-test.html.twig");

        // all done? clean up
        ldap_close($ldap_connection1);
    }

}