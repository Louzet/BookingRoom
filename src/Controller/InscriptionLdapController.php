<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\CreateInscriptionLdapType;
use App\Entity\InscriptionLdap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use transliteratorSlugTrait;

class InscriptionLdapController extends AbstractController
{
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
        $room = new Room();

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
                    'Félicitation, votre ldap est enregistré !');

                # 3.1 Récupération des rooms

                #dump($result1);
                #dump($result2);

                # 3.2 Persistance des rooms en bases
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($room);
                    $em->flush();


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
