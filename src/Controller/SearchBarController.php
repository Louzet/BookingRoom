<?php

namespace App\Controller;

use App\Entity\Search_bar;
use App\Form\SearchBarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchBarController extends AbstractController
{
    public function search(Request $request): Response
    {
        $newSearch = new Search_bar();

        $form = $this->createForm(SearchBarType::class, $newSearch)->handleRequest($request);

        return $this->render('booking/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
