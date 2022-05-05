<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campagne;
use App\Entity\CampagneRecolte;
use App\Entity\Recolte;
use App\Entity\Parcelle;
use App\Form\AjoutPoidsRecolteType;
use App\Entity\PoidsRemorqueRecolte;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class DetailCampagneRecolteController extends AbstractController
{
    #[Route('/detail/campagne/recolte/{idCampagneRecolte}', name: 'detail_campagne_recolte')]
    public function DetailsRecolte(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte): Response
    {
        $campagneRecolte = $doctrine->getRepository(CampagneRecolte::Class)->findOneby(array('id'=> $idCampagneRecolte));
        $listeParcelle = $doctrine->getRepository(Recolte::Class)->findBy(array('campagneRecolte' => $idCampagneRecolte));
          

        foreach ($listeParcelle as $parcelle){
            $poidsTotal = 0;
            $matiereSeche= 0;
            $nb = 0;
            $allPoids = $parcelle->getRemorques();

            foreach ($allPoids as $poids){
                $nb = $nb +1;
                $poidsTotal = $poidsTotal + $poids->getPoids();
                $matiereSeche = $matiereSeche + $poids->getMatiereSeche();
                //dump($poidsTotal);
            }

            if($nb != 0){
                $matiereSeche = $matiereSeche / $nb;
                $parcelle->setMatiereSecheMoy($matiereSeche);
            }
            $parcelle->setPoidsTotal($poidsTotal);


            $em = $doctrine->getManager();
            $em->persist($parcelle);
            $em->flush();
        }
        
        return $this->render('detail_campagne_recolte/index.html.twig', [
            'campagneRecolte'=>$campagneRecolte,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/recolte/encours/{idCampagneRecolte}', name: 'recolte_en_cours')]
    public function recolteEnCours(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte): Response
    {
        $campagneRecolte = $doctrine->getRepository(CampagneRecolte::Class)->findOneby(array('id'=> $idCampagneRecolte));
        $listeParcelle = $doctrine->getRepository(Recolte::Class)->findBy(array('campagneRecolte' => $idCampagneRecolte));
       
        if($request->isMethod('POST')){
            $idRecolte = $_POST['idRecolte'];
            $recolte = $doctrine->getRepository(Recolte::class)->find($idRecolte);     
            $recolte->setEffectuer(1);

            $em = $doctrine->getManager();
            $em->persist( $recolte);
            $em->flush();
        }

        return $this->render('detail_campagne_recolte/index.html.twig', [
            'campagneRecolte'=>$campagneRecolte,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/recolte/terminer/{idCampagneRecolte}', name: 'recolte_termine')]
    public function recolteTermine(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte): Response
    {
        $campagneRecolte = $doctrine->getRepository(CampagneRecolte::Class)->findOneby(array('id'=> $idCampagneRecolte));
        $listeParcelle = $doctrine->getRepository(Recolte::Class)->findBy(array('campagneRecolte' => $idCampagneRecolte));
       
        if($request->isMethod('POST')){
            $idRecolte = $_POST['idRecolte'];
            $commentaire = $_POST['commentaire'];
            $recolte = $doctrine->getRepository(Recolte::class)->find($idRecolte);     
            $recolte->setEffectuer(2);
            $recolte->setCommentaire($commentaire);

            $em = $doctrine->getManager();
            $em->persist( $recolte);
            $em->flush();
        }

        return $this->render('detail_campagne_recolte/index.html.twig', [
            'campagneRecolte'=>$campagneRecolte,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/recolte/annuler/{idCampagneRecolte}', name: 'recolte_non_effectue')]
    public function recolteAnnule(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte): Response
    {
        $campagneRecolte = $doctrine->getRepository(CampagneRecolte::Class)->findOneby(array('id'=> $idCampagneRecolte));
        $listeParcelle = $doctrine->getRepository(Recolte::Class)->findBy(array('campagneRecolte' => $idCampagneRecolte));
       
        if($request->isMethod('POST')){
            $idRecolte = $_POST['idRecolte'];
            $recolte = $doctrine->getRepository(Recolte::class)->find($idRecolte);     
            $recolte->setEffectuer(1);

            $em = $doctrine->getManager();
            $em->persist( $recolte);
            $em->flush();
        }

        return $this->render('detail_campagne_recolte/index.html.twig', [
            'campagneRecolte'=>$campagneRecolte,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/recolte/poids/{idCampagneRecolte}/{idParcelle}', name: 'ajouter_poids_remorque')]
    public function ajouterPoidsRemorque(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte, int $idParcelle): Response
    {
        $poidsRemorque = new PoidsRemorqueRecolte();
        $form = $this->createForm(AjoutPoidsRecolteType::class, $poidsRemorque);
        $recolte = $doctrine->getRepository(Recolte::Class)->findOneby(array('id'=> $idParcelle));

       
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

                $poidsRemorque->setRecolte($recolte);
                $em = $doctrine->getManager(); 
                $em->persist($poidsRemorque);
                $em->flush();

                
                return $this->redirectToRoute('detail_campagne_recolte', ['idCampagneRecolte' => $idCampagneRecolte]);
            }
        }

        return $this->render('detail_campagne_recolte/ajoutPoids.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
