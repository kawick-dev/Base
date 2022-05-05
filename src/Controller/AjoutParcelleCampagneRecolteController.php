<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parcelle;
use App\Entity\Recolte;
use App\Entity\Campagne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CampagneRecolte;

class AjoutParcelleCampagneRecolteController extends AbstractController
{
    #[Route('/ajout/parcelle/campagne/recolte/{idCampagneRecolte}', name: 'ajout_parcelle_campagne_recolte')]
    public function AjoutParcelleRecolte(ManagerRegistry $doctrine,Request $request,int $idCampagneRecolte): Response
    {
        $campagne = $doctrine->getRepository(CampagneRecolte::Class)->find($idCampagneRecolte);
        $parcelles = $doctrine->getRepository(Parcelle::class)->findBy(array(), array('id'=>'DESC'));
        $recoltelist = $doctrine->getRepository(Recolte::class)->findBy(array('campagneRecolte' => $idCampagneRecolte));
        $listParcelle = [];
        foreach ($recoltelist as $recolte){
            $listParcelle[] = $recolte->getParcelle()->getId();
                    
        }
        //dump($listParcelle);
        //dump($parcelles);

        if($request->isMethod('POST')){

            $culture = $_POST['culture'];
            $idParcelle = $_POST['idParcelle'];
            $recolte = new Recolte();      

            $recolte->setParcelle($doctrine->getRepository(Parcelle::class)->findOneby(array('id'=> $idParcelle)));
            $recolte->setCampagneRecolte($doctrine->getRepository(CampagneRecolte::class)->findOneby(array('id'=> $idCampagneRecolte)));
            $recolte->setEffectuer(0);
            $recolte->setCulture($culture);
            $em = $doctrine->getManager();
            $em->persist($recolte);
            $em->flush();
            header("Refresh:0");

        }

 
        return $this->render('ajout_parcelle_campagne_recolte/index.html.twig', [
            'campagne'=>$campagne,
            'parcelles'=>$parcelles,
            'listParcelle'=>$listParcelle
        ]);
    }
}
