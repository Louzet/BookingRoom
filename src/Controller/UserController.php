<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/registration", name="user.registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        # Création d'un utilisateur en base mysql
        $user = new User();

        # Création du formulaire
        $form = $this->createForm(UserRegistrationType::class, $user)
            ->handleRequest($request);

        # Si le formulaire est soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $this->manager->persist($user);

            $this->manager->flush();

            # Notification
            $this->addFlash(
                "success",
                "Félicitation, vous pouvez maintenant vous connecter"
            );

            # Redirection vers la page de connexion
            return $this->redirectToRoute("booking.login");

        }

        return $this->render("user/registration.html.twig", [
            'form'  => $form->createView()
        ]);
    }

}

/*
$user = new User();*/