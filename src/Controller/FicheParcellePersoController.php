<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parcelle;
use App\Entity\Epandage;
use App\Entity\Campagne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class FicheParcellePersoController extends AbstractController
{
    #[Route('/fiche/parcelle/perso/{idParcelle}', name: 'fiche_parcelle_perso')]
    public function index(ManagerRegistry $doctrine,Request $request,int $idParcelle): Response
    {
        $parcelle = $doctrine->getRepository(Parcelle::Class)->find($idParcelle);
        $listeCampagne = $doctrine->getRepository(Epandage::Class)->findBy(array('parcelle' => $idParcelle));
        //dump($listeCampagne);

        return $this->render('fiche_parcelle_perso/index.html.twig', [
            'parcelle'=>$parcelle,
            'listeCampagne'=>$listeCampagne
        ]);
    }
}
