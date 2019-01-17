<?php

namespace App\Controller\Professionnels;

use App\Entity\Professionnal;
use App\Form\ProfessionnalRegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfessionnelsController extends AbstractController
{
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
}
