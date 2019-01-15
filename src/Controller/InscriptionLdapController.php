<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionLdapController extends AbstractController
{
    /**
     * @Route("/inscription/ldap", name="inscription_ldap")
     */
    public function index()
    {
        return $this->render('inscription_ldap/index.html.twig', [
            'controller_name' => 'InscriptionLdapController',
        ]);
    }
}
