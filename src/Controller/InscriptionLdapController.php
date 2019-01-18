<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\CreateInscriptionLdapType;
use App\Entity\InscriptionLdap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class InscriptionLdapController extends AbstractController
{

    use TransliteratorSlugTrait;
     /**
     * Formulaire pour ajouter un LDAP
     * @Route("/creer-un-ldap",
     *     name="booking.inscriptionLdap")
     * @param Request $request
     * @return Response
     */
    public function newInscriptionLdap(Request $request)
    {
        $inscriptionLdap = new InscriptionLdap();
        //$room = new Room();

        $form = $this->createForm(CreateInscriptionLdapType::class, $inscriptionLdap)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

                //dump($form);
            /**
             * Setup 1
             */
            //$ldap_password = 'nimdaLDAP_1';
            $ldap_password = $form->get("password");
            //$ldap_username = 'cn=admin,dc=ldap,dc=agopreneur,dc=fr';
            $ldap_username = $form->getData()->getBinddn();
            dump($ldap_password,$ldap_username);
            //die();
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





                # 1. Mise à jour du Slug

                $inscriptionLdap->setSlug($this->slugify($inscriptionLdap->getName()));

                # 2. Sauvegarde en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($inscriptionLdap);
                $em->flush();

                # 3. Notification
                $this->addFlash('notice',
                    'Félicitation, votre ldap est enregistré !');

                # 3.1 Récupération des rooms

                #dump($result1);
                #dump($result2);

                # 3.2 Persistance des rooms en bases
                    //$em = $this->getDoctrine()->getManager();
                    //$em->persist($room);
                    //$em->flush();


                # 4. Redirection vers le ldap créé
                return $this->redirectToRoute('index_inscriptionLdap', [
                    'slug' => $inscriptionLdap->getSlug(),
                    'id' => $inscriptionLdap->getId()
                ]);

            }

        # Affichage du Formulaire
        return $this->render('booking/inscriptionLdap.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editer-ldap/{id<\d+>}",
     *     name="booking.inscriptionLdapEdit")
     * @param InscriptionLdap $inscriptionLdap
     * @param Request $request
     * @return Response
     */
    public function editInscriptionLdap(InscriptionLdap $inscriptionLdap,
                                Request $request)
    {

        # Création / Récupération du Formulaire
        $form = $this->createForm(CreateInscriptionLdapType::class, $inscriptionLdap)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {

            # 1. Mise à jour du Slug
            $inscriptionLdap->setSlug($this->slugify($inscriptionLdap->getName()));

            # 2. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscriptionLdap);
            $em->flush();

            # 3. Notification
            $this->addFlash('notice',
                'Félicitation, votre ldap est mis à jour !');

            # 4. Redirection vers l'article créé
            return $this->redirectToRoute('inscriptionLdap_edit', [
                'id' => $inscriptionLdap->getId()
            ]);

        }

        # Affichage du Formulaire
        return $this->render('booking/inscriptionLdap.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
