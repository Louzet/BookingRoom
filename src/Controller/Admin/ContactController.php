<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactAdminType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @param Request       $request
     * @param ObjectManager $manager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contact-us", name="admin.contact")
     */
    public function contactAdmin(Request $request, ObjectManager $manager)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactAdminType::class, $contact)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($contact);

            $manager->flush();
        }

        return $this->render('booking/contact_admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
