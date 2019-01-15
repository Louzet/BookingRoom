<?php

namespace App\Controller\Errors;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FailLoginController extends AbstractController
{
    /**
     * @Route("/error-429", name="fail.too.many.login")
     */
    public function failLogin()
    {
        return $this->render('errors/error_429.html.twig');
    }

}