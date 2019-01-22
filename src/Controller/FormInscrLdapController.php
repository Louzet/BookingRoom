<?php

namespace App\Controller;


use App\Entity\InscriptionLdap;
use App\Entity\Room;
use App\Form\CreateInscriptionLdapType;
use Doctrine\Common\Collections\ArrayCollection;
use LdapTools\Configuration;
use LdapTools\DomainConfiguration;
use LdapTools\LdapManager;
use LdapTools\Object\LdapObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormInscrLdapController extends AbstractController
{

    use TransliteratorSlugTrait;

    /**
     * Formulaire pour ajouter un LDAP
     * @Route("/creer-un-ldap",
     *     name="booking.inscriptionLdap")
     * @param Request $request
     * @return Response
     */
    public function newFormInscriptionLdap(Request $request)
    {
        /**
         * Création du formulaire
         */

        $inscriptionLdap = new InscriptionLdap();

        $form = $this->createForm(CreateInscriptionLdapType::class, $inscriptionLdap)
            ->handleRequest($request);


        # Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {


            # 2. Mise à jour du Slug
            $inscriptionLdap->setSlug($this->slugify($inscriptionLdap->getName()));

            /**
             * Récupération dynamique depuis le formulaire des valeurs saisies par l'utilisateur
             */
            //$ldap_name = 'Agopreneur'
            $ldap_name = $form->getData()->getName();

            //$ldap_hostname = 'ldap.agopreneur.fr';
            $ldap_hostname = $form->getData()->getHostname();

            //$ldap_port = 389
            $ldap_port = $form->getData()->getPort();

            //$ldap_basedn = 'dc=ldap,dc=agopreneur,dc=fr';
            $ldap_basedn = $form->getData()->getBasedn();

            //$ldap_binddn = 'cn=admin,dc=ldap,dc=agopreneur,dc=fr';
            $ldap_binddn = $form->getData()->getBinddn();

            //$ldap_password = 'nimdaLDAP_1';
            $ldap_password = $form->getData()->getPassword();

            //$ldap_privee => booleen (réservation privée des salles Oui/Non)
            $ldap_privee = $form->getData()->getPrivee();

            // A new configuration object contains the most common default settings.
            $config = new Configuration();

            // A domain configuration object. Requires a domain name, servers, username, and password.
            $domain = (new DomainConfiguration())
                ->setDomainName($ldap_hostname)
                ->setBaseDn($ldap_basedn)
                ->setBindFormat('cn=%username%,' . $ldap_basedn)
                ->setPort($ldap_port)
                ->setUsername('admin')
                ->setPassword($ldap_password)
                ->setLdapType('openldap')
                ->setServers([$ldap_hostname]);

            $config->addDomain($domain);

            // The LdapManager provides an easy point of access to some different classes.
            $ldap = new LdapManager($config);

            //Test rechercher les rooms
            $query = $ldap->buildLdapQuery();

            // Returns a LdapObjectCollection of all room
            $rooms = $query
                ->select(['dn', 'description'])
                ->where(['objectClass' => 'room'])
                ->getLdapQuery()
                ->getResult();

            $roomColl = new ArrayCollection();

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($inscriptionLdap);

            foreach ($rooms as $roomLdap) {
                /**  @var LdapObject $roomLdap */
                $roomDb = new Room();
                $roomDb->setName($roomLdap->get('dn'));
                $roomDb->setSlug($roomDb->getName());
                $roomDb->setPriceLocation(0);
                $roomDb->setPlaceCapacity(str_replace(" places","",$roomLdap->get('description')));
                $roomDb->setVille('');
                $roomDb->setAddress('');
                $roomDb->setPostalCode(0);
                $roomDb->setDisponible(0);
                $roomDb->setPrivee($inscriptionLdap->getPrivee());
                $roomDb->setType();
                $roomDb->setInscriptionLdap($inscriptionLdap);
                $roomColl->add($roomDb);
                $em->persist($roomDb);
            }

            $inscriptionLdap->setRooms($roomColl);

            dump($inscriptionLdap);

            $em->flush();
            die();



            # 4. Notification
            $this->addFlash('notice',
            'Félicitation, votre LDAP a bien été enregistré !');

            # 5. Redirection vers l'affichage des rooms créé
            return $this->redirectToRoute('index_article', [
               'categorie' => $article->getCategorie()->getSlug(),
               'slug' => $article->getSlug(),
               'id' => $article->getId()
            ]);


        }

        # Affichage du Formulaire
        return $this->render('booking/inscriptionLdap.html.twig', [
            'form' => $form->createView()
        ]);

    }
}