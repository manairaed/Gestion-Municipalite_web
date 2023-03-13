<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class CategorieController extends AbstractController
{
    /**
     * @Route("/afficherr", name="display_cat")
     */
    public function index(): Response
    {
        $cat=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        // $arb=$paginator->paginate(
        //     $amir,
        //     $request->query->getInt('page',1),
        //     3

        // ) ;

        return $this->render('categorie/list.html.twig', [
            'a'=>$cat
        ]);
    }

    /**
     * @Route("/addcat", name="addcat")
     */
    public function addcategorie(Request $request): Response
    {
        $foot = new Categorie();
        $form=$this->createForm(CategorieType::class,$foot);
        $form->HandleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($foot);
            $em->flush();
            return $this->redirectToRoute('display_cat');
        }
        return $this->render('categorie/index.html.twig',['a'=>$form->createView()]);

    }

     /**
     * @Route("/supprimer/{id}", name="supp_cat")
     */
    public function supprimer(Categorie $foot): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em-> remove($foot);
        $em->flush();
        return $this->redirectToRoute('display_cat');
    }

      /**
     * @Route("/modifierMatch/{id}", name="modifiercat")
     */
    public function modifiercategorie(Request $request,$id): Response
    {
        $foot = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($id);
        $form=$this->createForm(CategorieType::class,$foot);
        $form->HandleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('display_cat');
        }
        return $this->render('categorie/update.html.twig',['a'=>$form->createView()]);

    }

    

    // /**
    //  * @Route("/search", name="rechercheveh", methods={"GET"})
    //  */

    //  public function searchoffreajax(Request $request, CategorieRepository $FootRepository): Response
    //  {
    //      $FootRepository = $this->getDoctrine()->getRepository(Categorie::class);
    //      $requestString = $request->get('searchValue');
    //      $foot = $FootRepository->findBycat($requestString);
 
    //      return $this->render('arbitre_match/index.html.twig', [
    //          "a" => $foot
    //      ]);
    //  }

    //   /**
    //  * @Route("/TrierspcASC", name="triespc",methods={"GET"})
    //  */

    // public function trierSpecialite(Request $request, CategorieController $ArbitreMatchRepository): Response
    // {

    //     $ArbitreMatchRepository = $this->getDoctrine()->getRepository(Categorie::class);
    //     $arb = $ArbitreMatchRepository->trie();

    //     return $this->render('arbitre_match/index.html.twig', [
    //         'a' => $arb,
    //     ]);
    // }

    /**
     * @Route("/listArb", name="listArb", methods={"GET"})
     */

  

}
