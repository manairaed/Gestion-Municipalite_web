<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Vehicule;


use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use PHPUnit\Util\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;




class MobileController extends AbstractController
{
     /**
     * @Route("/allVehicules", name="app_mobile")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $vehicules = $this->getDoctrine()->getManager()
            ->getRepository(Vehicule::class)
            ->findAll();

        $jsonContent = $normalizer->normalize($vehicules,'json',['groups'=>'vehicules']);

        return new JsonResponse($jsonContent);


    }



 

    /**
     * @Route("/detailVehicule", name="detail_mobile")
     */

    public function DetailVehicule(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $vehicule=$em->getRepository(Vehicule::class)->find($id);
        $encoder= new JsonEncoder();
        $normalizer=new ObjectNormalizer();
   
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($vehicule);

        return new JsonResponse($formatted);


    }






        /**
     * @Route("/AddVehicule", name="ajouteVehicule")
     */
    public function add_vehicule( NormalizerInterface $normalizable, EntityManagerInterface $entityManager, Request $request)
    {

        $vehicule = new Vehicule();
        $user2 = $this->getDoctrine()->getRepository(Categorie::class)->find(2); 
        $vehicule->setCategorie($user2);
        $vehicule->setmarque($request->get("marque"));
        $vehicule->setdisponible($request->get("disponible"));
     
        $entityManager->persist($vehicule);
        $entityManager->flush();
        return new JsonResponse([
            'success' => "vehicule has been added"
        ]);
    }

/**
     * @Route("/delete/{id}", name="delete vehicule")
     */
    public function deleteVehicule(Request $request, NormalizerInterface $normalizer, $id): Response
    {
        $repository = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $vehicule = $repository->getRepository(Vehicule::class)->find($id);
        $repository->remove($vehicule);
        $repository->flush();
        $jsonContent = $normalizer->normalize($vehicule, 'json', ['groups' => 'post:read']);
        return new Response(json_encode("vehicule deleted Successfully "));
    }
    

    


    
    /**
     * @Route("/deleteJson/{id}",name="deleteJson")
     */

    // public function deleteVehicule(EntityManagerInterface $em,Request $request,NormalizerInterface $normalizer,$id):Response
    // {
    //     $id=$request->query->get("id");
    //     $vehicule= $em
    //         ->getRepository(Vehicule::class)
    //         ->find($id);
    //         //dd($vehicule);
    //     $em->remove($vehicule);
    //     $em->flush();
    //     $jsonContent = $normalizer->normalize($vehicule,'json',['groups'=>'vehicules']);
    //     return new Response(json_encode($jsonContent));

    // }



   





/**
     * @Route("/edit/{id}", name="edit vehicule")
     */
public function editVehicule(Request $request, EntityManagerInterface $em,$id):Response
     {
        $vehicule = new Vehicule();
        $vehicule->getId($request->query->get("id"));
        
        $vehicule = $em
            ->getRepository(Vehicule::class)
           ->find($id);

           $vehicule->setMarque($request->get("marque"));
           $vehicule->setDisponible($request->get("disponible"));
          

        $this->getDoctrine()->getManager()->persist($vehicule);

        $this->getDoctrine()->getManager()->flush();
         return new Response(json_encode("vehicule edited Successfully "));

     }
    //  /**
    //  * @Route("/edit/vehicule/{id}",name="editvehicule")
    //  */

    // public function editVehicule(Request $request, EntityManagerInterface $em):Response
    // {
    //     $vehicule = new Vehicule();
       
        
    //     $vehicule = $em
    //         ->getRepository(Vehicule::class)
    //         ->find($vehicule->getId());

    //     $vehicule->setmarque($request->query->get("marque"));
    //     $vehicule->setdisponible($request->query->get("disponible"));
     

    //     //dd($vehicule);

    //     $this->getDoctrine()->getManager()->persist($vehicule);

    //     $this->getDoctrine()->getManager()->flush();
    //     return $this->json(array('title'=>'successful','message'=> "Vehicule modifié avec succès"),200);

    // }



}