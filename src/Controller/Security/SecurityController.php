<?php

namespace App\Controller\Security;

use App\Form\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="booking.login")
     * @param           AuthenticationUtils $authenticationUtils
     * @return          \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser())
        {
            return $this->redirectToRoute("booking.home");
        }

        $form = $this->createForm(
            UserLoginType::class,
            [
                '_username' => $authenticationUtils->getLastUsername()
            ]
        );

        // Récupération du message d'erreur s'il y en a un.
        $error = $authenticationUtils->getLastAuthenticationError();

        // Affichage du Formulaire
        return $this->render(
            "user/login.html.twig",
            [
                'form'       => $form->createView(),
                'error'      => $error
            ]
        );
    }

    /**
     * @Route("/logout", name="booking.logout")
     */
    public function logout()
    {

    }
}
