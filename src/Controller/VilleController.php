<?php

namespace App\Controller;

use App\Repository\VillesFranceFreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VilleController extends AbstractController
{
    /**
     * @var VillesFranceFreeRepository
     */
    private $villesRepository;

    public function __construct(VillesFranceFreeRepository $villesFranceFreeRepository)
    {
        $this->villesRepository = $villesFranceFreeRepository;
    }

    /**
     * @Route(
     *     "/villes/json-villes/{_query}",
     *     name="villes-json",
     *     methods={"POST", "GET"},
     *     options={"expose" = true},
     *     )
     *
     * @param $_query
     *
     * @return Response
     */
    public function getVilles($_query)
    {
        /* $data = json_decode($request->getContent());
         $query = $data->query;*/
        if ($_query) {
            $data = $this->villesRepository->findVillesByName($_query);
        } else {
            $data = $this->villesRepository->findAll();
        }

        $normalizers = [
            new ObjectNormalizer(),
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($data, 'json');

        return new JsonResponse($data, 200, [], true);
    }


}
