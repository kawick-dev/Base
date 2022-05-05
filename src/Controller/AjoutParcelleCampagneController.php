<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campagne;
use App\Entity\CampagneRecolte;
use App\Entity\Parcelle;
use App\Entity\Epandage;
use App\Entity\Recolte;
use App\Form\CampagneQuantiteParcelleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class AjoutParcelleCampagneController extends AbstractController
{
    #[Route('/ajout/parcelle/campagne/{idCampagne}', name: 'ajout_parcelle_campagne')]
    public function index(ManagerRegistry $doctrine,Request $request,int $idCampagne): Response
    {
        $campagne = $doctrine->getRepository(Campagne::Class)->find($idCampagne);
        $parcelles = $doctrine->getRepository(Parcelle::class)->findBy(array(), array('id'=>'DESC'));
        $epandagelist = $doctrine->getRepository(Epandage::class)->findBy(array('campagne' => $idCampagne));
        $listParcelle = [];
        foreach ($epandagelist as $epandage){
            $listParcelle[] = 
                $epandage->getParcelle()->getId();
            
            
        }
        //dump($listParcelle);
        //dump($parcelles);

        if($request->isMethod('POST')){
            $surfaceEpandue = $_POST['surfaceEpandue'];
            $quantite = $_POST['quantite'];
            $culture = $_POST['culture'];
            $idParcelle = $_POST['idParcelle'];
            $epandage = new Epandage();      

            $epandage->setParcelle($doctrine->getRepository(Parcelle::class)->findOneby(array('id'=> $idParcelle)));
            $epandage->setCampagne($doctrine->getRepository(Campagne::class)->findOneby(array('id'=> $idCampagne)));
            $epandage->setEffectuer(False);
            $epandage->setQuantite($quantite);
            $epandage->setCulture($culture);
            $epandage->setSurfaceEpandue($surfaceEpandue);
            $em = $doctrine->getManager();
            $em->persist($epandage);
            $em->flush();
            header("Refresh:0");

        }

 
        return $this->render('ajout_parcelle_campagne/index.html.twig', [
            'campagne'=>$campagne,
            'parcelles'=>$parcelles,
            'listParcelle'=>$listParcelle
        ]);
    }

}
