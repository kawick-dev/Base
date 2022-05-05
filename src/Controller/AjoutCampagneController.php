<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use App\Form\AddCampagneType;
use App\Entity\Campagne;
use App\Entity\CampagneRecolte;

class AjoutCampagneController extends AbstractController
{
    #[Route('/ajout/campagne', name: 'ajout_campagne')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $campagne = new Campagne();
        $form = $this->createForm(AddCampagneType::class, $campagne);
 
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $em = $doctrine->getManager(); 
                $em->persist($campagne);
                $em->flush();
                return $this->redirectToRoute('liste_campagne');
            }
        }

        return $this->render('ajout_campagne/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/ajout/campagne/recolte', name: 'ajout_campagne_recolte')]
    public function AjoutCampagneRecolte(Request $request, ManagerRegistry $doctrine): Response
    {
        $campagneRecolte = new CampagneRecolte();
        $form = $this->createForm(AddCampagneType::class, $campagneRecolte);
 
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $em = $doctrine->getManager(); 
                $em->persist($campagneRecolte);
                $em->flush();
                return $this->redirectToRoute('liste_campagne');
            }
        }

        return $this->render('ajout_campagne/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
