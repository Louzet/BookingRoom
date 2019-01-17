<?php


namespace App\Controller;


use App\Entity\InscriptionLdap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="booking.home")
     */
    public function home()
    {
        return $this->render('booking/home.html.twig');
    }

    /**
     * Afficher un Ldap
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
        # On s'assure que l'article ne soit pas null.
        if (null === $inscriptionLdap) {

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
        return $this->render('inscriptionLdap/inscriptionLdap.html.twig', [
            'inscriptionLdap' => $inscriptionLdap
        ]);
    }
}