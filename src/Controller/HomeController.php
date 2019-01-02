<?php
/**
 * Created by PhpStorm.
 * User: Nix
 * Date: 02/01/2019
 * Time: 11:06
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    /**
     * @Route("/home", name="booking.home")
     */
    public function home()
    {
        return new Response("<html><body>Home page</body></html>");
    }
}