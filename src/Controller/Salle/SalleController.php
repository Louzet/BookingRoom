<?php

namespace App\Controller\Salle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class SalleController extends AbstractController
{
    /**
     * @Route("/list", name="salles.list")
     */
    public function salleIndex()
    {

    }

}
