<?php

namespace App\Controller;


use App\Entity\InscriptionLdap;
use App\Form\InscriptionLdapType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionLdapController extends AbstractController
{
    /**
     * @Route("/inscriptionLdap", name="booking.inscriptionLdap")
     */
    public function inscriptionLdap(Request $request)
    {
        $ldap=new InscriptionLdap();
        $form=$this->createForm(InscriptionLdapType::class,$ldap)->handleRequest($request);
        return $this->render('booking/inscriptionLdap.html.twig',[
            'form' => $form-> createView()
        ]);

    }
}