<?php

namespace App\Controller\Professionnels;

use App\Entity\Professionnal;
use App\Entity\Reservation;
use App\Form\ProfessionnalRegistrationType;
use App\Form\ProfessionnelProfilType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ProfessionnelsController.
 */
class ProfessionnelsController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * ProfessionnelsController constructor.
     *
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/registration/professionnals", name="pro.registration")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ObjectManager                $manager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function ProRegistration(Request $request, UserPasswordEncoderInterface $passwordEncoder, ObjectManager $manager)
    {
        // Création d'un utilisateur en base mysql
        $professionnal = new Professionnal();

        // Création du formulaire
        $form = $this->createForm(ProfessionnalRegistrationType::class, $professionnal)
            ->handleRequest($request);

        // Si le formulaire est soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordEncoder->encodePassword($professionnal, $professionnal->getPassword());

            $professionnal->setPassword($hash);

            $manager->persist($professionnal);

            $manager->flush();

            // Notification
            $this->addFlash(
                'success',
                'Félicitation, vous pouvez maintenant vous connecter'
            );

            // Redirection vers la page de connexion
            return $this->redirectToRoute('user.login');
        }

        return $this->render('professionnal/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/{}username}", name="pro.profil")
     * @Security("has_role('ROLE_PROFESSIONNAL')")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function professionnalProfil(Request $request)
    {
        $professionnel = $this->getUser();

        if (null === $professionnel) {
            return $this->redirectToRoute('user.login');
        }

        $username = $this->getUser()->getUsername();

        $form = $this->createForm(ProfessionnelProfilType::class, $professionnel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($professionnel);

            $this->manager->flush();

            $this->addFlash('success', 'Modifications prises en compte !');

            return $this->redirectToRoute('pro.profil', [
                'username' => $username,
            ]);
        }

        return $this->render('professionnal/profil.html.twig', [
            'form' => $form->createView(),
            'username' => $username,
        ]);
    }

    /**
     * @param Request $request
     *
     * Retournes toutes les réservations éffectuées pour des salles appartenant au professionnel courant
     * @return Response
     */
    public function myReservationsConfirmed(Request $request): Response
    {
        $professionnel = $this->getUser();

        $id = $professionnel->getId();

        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)->findMyReservationsByStatus($id, 'accepted');

        dump($reservations);

        return $this->render('professionnal/reservation-confirmed.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
