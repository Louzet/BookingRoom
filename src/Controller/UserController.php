<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\UserProfileType;
use App\Form\UserRegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/registration", name="user.registration")
     *
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Création d'un utilisateur en base mysql
        $user = new User();

        // Création du formulaire
        $form = $this->createForm(UserRegistrationType::class, $user)
            ->handleRequest($request);

        // Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $this->manager->persist($user);

            $this->manager->flush();

            // Notification
            $this->addFlash(
                'success',
                'Félicitation, vous pouvez maintenant vous connecter'
            );

            // Redirection vers la page de connexion
            return $this->redirectToRoute('user.login');
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profil/{username}", name="user.profil")
     */
    public function profil(Request $request)
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('user.login');
        }

        $username = $this->getUser()->getUsername();

        $form = $this->createForm(UserProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($user);

            $this->manager->flush();

            $this->addFlash('success', 'Modifications prises en compte !');

            return $this->redirectToRoute('user.profil', [
                'username' => $username,
            ]);
        }

        return $this->render('user/profil.html.twig', [
            'form' => $form->createView(),
            'username' => $username,
        ]);
    }

    /**
     * Afficher les réservation d'un client.
     */
    public function reservationsEnAttente(): Response
    {
        $user = $this->getUser();

        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findReservationsByStatus($user->getId(), 'on_pending');

        dump($reservations);

        return $this->render('components/_reservations-on-pending.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
