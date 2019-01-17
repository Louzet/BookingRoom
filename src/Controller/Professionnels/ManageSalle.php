<?php

namespace App\Controller\Professionnels;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ManageSalle extends AbstractController
{
    public function __construct()
    {
    }

    public function managementSalle()
    {
        return $this->render('professionnal/Management_salle.html.twig');
    }
}
