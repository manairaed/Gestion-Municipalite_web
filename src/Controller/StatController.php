<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]
    public function index(): Response
    {
        return $this->render('stat/index.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }

/**
     * @Route("/stats", name="stats")
     */
    public function statistiques(VehiculeRepository $produitRepository){
        

        $entityManager = $this->getDoctrine()->getManager();
        $data = $entityManager->getRepository(Vehicule::class)->findAll();


        $marqData = array_map(function($datum) {
            return $datum->getId();
        }, $data);
        
        $prixData = array_map(function($datu) {
            return $datu->getId();
        }, $data);

        return $this->render('stat/index.html.twig', [
            'marqData' => json_encode($marqData),
            'prixData'=> json_encode($prixData)
        ]);

    }

}


