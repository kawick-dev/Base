<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class ListeUtilisateurController extends AbstractController
{
    #[Route('/liste/utilisateur', name: 'liste_utilisateur')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findBy(array(), array('username'=>'DESC'));
        return $this->render('liste_utilisateur/index.html.twig', [
            'users'=>$users
        ]);
    }
}
