<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campagne;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\CampagneRecolte;

class ListeCampagneController extends AbstractController
{
    #[Route('/liste/campagne', name: 'liste_campagne')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $campagnes = $doctrine->getRepository(Campagne::class)->findBy(array(), array('id'=>'DESC'));
        $campagnesRecolte = $doctrine->getRepository(CampagneRecolte::class)->findBy(array(), array('id'=>'DESC'));

        return $this->render('liste_campagne/index.html.twig', [
           'campagnes'=>$campagnes, 'campagnesRecolte'=>$campagnesRecolte
        ]);
    }
}
