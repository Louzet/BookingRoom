<?php

namespace App\Controller;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/home", name="booking.home")
     * @Route("/", name="booking")
     */
    public function home(LoggerInterface $logger)
    {
        $logger->notice(sprintf('test de log depuis wf3'));
        return $this->render("booking/home.html.twig", [

        ]);
    }

    public function carousel()
    {
        return $this->render("components/_carousel.html.twig");
    }
}