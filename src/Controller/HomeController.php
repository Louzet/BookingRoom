<?php

namespace App\Controller;

use App\Entity\InscriptionLdap;
use App\Repository\RoomRepository;
use App\Repository\VillesFranceFreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;
    /**
     * @var VillesFranceFreeRepository
     */
    private $villeRepository;

    /**
     * HomeController constructor.
     *
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @Route("/home", name="booking.home")
     * @Route("/", name="booking")
     */
    public function home()
    {
        $availableRooms = $this->roomRepository->findAvailableRooms();

        return $this->render('booking/home.html.twig', [
            'availableRooms' => $availableRooms,
        ]);
    }

    public function carousel()
    {
        return $this->render('components/_carousel.html.twig');
    }

    /**
     * @Route("/result-query", name="search.query")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultSearch()
    {
        $response = $this->forward('App\Controller\SearchBarController::search');

        //dump($response);



        // ... further modify the response or return it directly

        return $this->render('booking/result-query.html.twig');
    }

    /**
     * Afficher une inscription Ldap
     * @Route("/{slug<[a-zA-Z1-9\-_\/]+>}_{id<\d+>}.html",
     *     name="index_inscriptionLdap")
     * @param $id
     * @param $slug
     * @param InscriptionLdap $inscriptionLdap
     * @return Response
     */
    public function inscriptionLdap($id,
                                    $slug,
                                    InscriptionLdap $inscriptionLdap = null)
    {
        # Exemple d'URL
        # contabo_1.html

        # $article = $this->getDoctrine()
        #     ->getRepository(Article::class)
        #     ->find($id);

        # On s'assure que l'inscriptionLdap ne soit pas null.
        if (null === $inscriptionLdap) {

            # On génère une exception
            # throw $this->createNotFoundException(
            #     "Nous n'avons pas trouvé votre article ID : " . $id
            # );

            # Ou, on redirige l'utilisateur sur la page d'accueil
            return $this->redirectToRoute('home', [],
                Response::HTTP_MOVED_PERMANENTLY);
        }

        # Vérification du SLUG
        if ($inscriptionLdap->getSlug() !== $slug) {
            return $this->redirectToRoute('index_inscriptionLdap', [
                'slug' => $inscriptionLdap->getSlug(),
                'id' => $id
            ]);
        }

        # Transmission des données à la vue
        return $this->render('booking/afficheInscriptionLdap.html.twig', [
            'inscriptionLdap' => $inscriptionLdap
        ]);
    }
}
