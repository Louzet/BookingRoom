<?php

namespace App\Controller\Professionnels;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfessionnalSecurity extends AbstractController
{
    private $error;

    /**
     * @Route("/professionnal/login", name="pro.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function Professionnal_login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('booking.home');
        }

        // Récupération du formulaire de connexion
        $form_professionnal = $this->createForm(ProfessionnalLoginType::class, [
            'email' => $authenticationUtils->getLastUsername(),
        ]);

        // Récupération du message d'erreur s'il y en a un.
        $this->error = $authenticationUtils->getLastAuthenticationError();

        // Affichage du Formulaire
        return $this->render('user/login.html.twig', [
                'form_professionnal' => $form_professionnal->createView(),
                'error' => $this->error,
            ]
        );
    }

    /**
     * @Route("/professionnal/logout", name="pro.logout")
     */
    public function Professionnal_logout()
    {
    }
}
