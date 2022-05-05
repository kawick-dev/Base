<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\EditUserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
class EditUserController extends AbstractController
{
    #[Route('/edit/user/{idUser}', name: 'edit_user')]
    public function index(Request $request, ManagerRegistry $doctrine, int $idUser): Response
    {
        $user = $doctrine->getRepository(User::class)->find($idUser);
        $form = $this->createForm(EditUserType::class, $user);
        
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid())
            {
                
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
            }
            
            return $this->redirectToRoute('liste_utilisateur');
        }

        return $this->render('edit_user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/user/{idUser}', name: 'delete_user')]
    public function delete(ManagerRegistry $doctrine, int $idUser): Response
    {
        $user = $doctrine->getRepository(User::class)->find($idUser);

        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('liste_utilisateur');
    }
}
