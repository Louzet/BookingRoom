<?php

namespace App\Controller\Security;

use App\Form\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $error;

    /**
     * @Route("/login", name="user.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('booking.home');
        }

        // Récupération du formulaire de connexion
        $form = $this->createForm(UserLoginType::class, [
            'email' => $authenticationUtils->getLastUsername(),
        ]);

        // Récupération du message d'erreur s'il y en a un.
        $this->error = $authenticationUtils->getLastAuthenticationError();

        $error_en = $this->error ? $this->error->getMessage() : '';

        // Affichage du Formulaire
        return $this->render('user/login.html.twig', [
                'form' => $form->createView(),
                'error' => $error_en,
            ]
        );
    }

    /**
     * @Route("/logout", name="user.logout")
     */
    public function logout()
    {
    }
}
