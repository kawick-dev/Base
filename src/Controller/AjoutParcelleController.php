<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Form\AddParcelleType;
use App\Form\FormCsvType;
use App\Entity\Parcelle;

class AjoutParcelleController extends AbstractController
{
    #[Route('/ajout/parcelle', name: 'ajout_parcelle')]
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $parcelle = new Parcelle();
        $form =$this->createForm(AddParcelleType::class, $parcelle);

        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                //dump($form->get('photo')->getData());

                if ($form->get('photo')->getData() == NULL){
                    $parcelle->setExploiter(TRUE);
                    $em = $doctrine->getManager(); 
                    $em->persist($parcelle);
                    $em->flush();
                    return $this->redirectToRoute('liste_parcelle');
                }
                else{
                    $fichierPhysique = $form->get('photo')->getData();
 
                    if ($fichierPhysique) {
                        $originalFilename = pathinfo($fichierPhysique->getClientOriginalName(), PATHINFO_FILENAME);
                        // this is needed to safely include the file name as part of the URL
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierPhysique->guessExtension();
        
                        // Move the file to the directory where brochures are stored
                        try {
                            $fichierPhysique->move($this->getParameter('file_directory'),$newFilename);
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                            $this->addFlash('notice','Erreur de création');
                        }
        
                        // updates the 'brochureFilename' property to store the PDF file name
                        // instead of its contents
                        $parcelle->setPhoto($newFilename);
                        $parcelle->setExploiter(TRUE);
                        $em = $doctrine->getManager(); 
                        $em->persist($parcelle);
                        $em->flush();
                        return $this->redirectToRoute('liste_parcelle');
                    }
                }

            }
        }

        return $this->render('ajout_parcelle/index.html.twig', [
           'form' => $form->createView(),
        ]);
    }



}


