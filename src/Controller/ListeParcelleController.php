<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parcelle;
use App\Entity\Epandage;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ParcelleModifType;
use App\Form\FormCsvType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ListeParcelleController extends AbstractController
{
    #[Route('/liste/parcelle', name: 'liste_parcelle')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $parcelles = $doctrine->getRepository(Parcelle::class)->findBy(array(), array('id'=>'DESC'));
        //dump($parcelles);

        return $this->render('liste_parcelle/index.html.twig', [
            'parcelles'=>$parcelles
        ]);


    }

    #[Route('/liste/parcelle-suppression/{idParcelle}', name: 'liste_parcelle_suppression')]
    public function parcelleSuppression(ManagerRegistry $doctrine, int $idParcelle): Response
    {
        $parcelle = $doctrine->getRepository(Parcelle::class)->find($idParcelle);
        $parcelle->setExploiter(False);
        $em = $doctrine->getManager();
        $em->persist($parcelle);
        $em->flush();

        return $this->redirectToRoute('liste_parcelle');
    }

    #[Route('/liste/parcelle-modification/{idParcelle}', name: 'liste_parcelle_modification')]
    public function parcelleModification(ManagerRegistry $doctrine, int $idParcelle, Request $request, SluggerInterface $slugger): Response
    {
        $parcelle = $doctrine->getRepository(Parcelle::class)->find($idParcelle);

        $formEditParcelle = $this->createForm(ParcelleModifType::class, $parcelle);

        if($request->isMethod('POST')){
            $formEditParcelle->handleRequest($request);
            if ($formEditParcelle->isSubmitted() && $formEditParcelle->isValid()){

                $em = $doctrine->getManager();
                $em->persist($parcelle);
                $em->flush();
            }
            return $this->redirectToRoute('liste_parcelle');
        }
        
       

        return $this->render('liste_parcelle_modif/index.html.twig', [
            'formEditParcelle' => $formEditParcelle->createView()
        ]);
    }
}
