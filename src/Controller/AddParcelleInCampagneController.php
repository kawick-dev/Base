<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Epandage;
use App\Entity\Parcelle;
use App\Entity\Campagne;
use App\Form\CampagneQuantiteParcelleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class AddParcelleInCampagneController extends AbstractController
{   
    #[Route('/add/parcelle/in/campagne/{idCampagne}', name: 'add_parcelle_in_campagne')]
    public function index(ManagerRegistry $doctrine, Request $request, int $idCampagne): Response
    {   

        $epandage = new Epandage();      
        $form = $this->createForm(Epandage::class, $epandage);

        $epandage->setIdParcelle($doctrine->getRepository(Parcelle::class)->findOneby(array('id'=> $idParcelle)));
        $epandage->setIdCampagne($doctrine->getRepository(Campagne::class)->findOneby(array('id'=> $idCampagne)));
        $epandage->setEffectuer(False);
        $em = $doctrine->getManager();
        $em->persist($epandage);
        $em->flush();
        

        return $this->redirectToRoute('ajout_parcelle_campagne', array('idCampagne'=>$idCampagne));
    }
}
