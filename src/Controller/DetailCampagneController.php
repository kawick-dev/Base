<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Campagne;
use App\Entity\CampagneRecolte;
use App\Entity\Epandage;
use App\Entity\Parcelle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use AppBundle\Form\Type\ExcelFormatType;


class DetailCampagneController extends AbstractController
{
    #[Route('/detail/campagne/{idCampagne}', name: 'detail_campagne')]
    public function index(ManagerRegistry $doctrine,Request $request,int $idCampagne): Response
    {
        $campagne = $doctrine->getRepository(Campagne::Class)->find($idCampagne);
        $listeParcelle = $doctrine->getRepository(Epandage::Class)->findBy(array('campagne' => $idCampagne));
        //dump($listeParcelle);
        $QuantiteTotal = 0;
        $SurfaceTotal = 0;
        $SurfaceEpandueTotal = 0;
        $SurfaceRealiser = 0;
    
        $epandages = $doctrine->getRepository(Epandage::Class)->findBy(array('campagne' => $idCampagne));
        foreach ($epandages as $epandage){  
            $SurfaceTotal = $SurfaceTotal + $epandage->getParcelle()->getSuperficie();
            $SurfaceEpandueTotal = $SurfaceEpandueTotal + $epandage->getSurfaceEpandue();
            $QuantiteTotal =  $QuantiteTotal + $epandage->getSurfaceEpandue() * $epandage->getQuantite();

            if($epandage->getEffectuer() == TRUE){
                $SurfaceRealiser = $SurfaceRealiser + $epandage->getSurfaceEpandue();
            }
        }

        $campagne->setQuantiteTotal($QuantiteTotal);
        $campagne->setSurfaceTotal($SurfaceTotal);
        $campagne->setSurfaceEpandueTotal($SurfaceEpandueTotal);
        $campagne->setSurfaceRealise($SurfaceRealiser);
        
        if($request->isMethod('POST')){
            $idEpandage = $_POST['idEpandage'];
            $commentaire = $_POST['commentaire'];
            $camion = $_POST['camion'];
            $epandage = $doctrine->getRepository(Epandage::class)->find($idEpandage);     
            $epandage->setEffectuer(2);
            $epandage->setDateEpandage(new \DateTime());
            $epandage->setCommentaire($commentaire);
            if ($camion != ""){
                $epandage->setCamion($camion);
            }
            else{
                $epandage->setCamion(0);
            }
            $em = $doctrine->getManager();
            $em->persist($epandage);
            $em->flush();
        }

        
        return $this->render('detail_campagne/index.html.twig', [
            'campagne'=>$campagne,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/epandage/false/{idCampagne}', name: 'epandage_non_effectue')]
    public function epandageNonEffectue(ManagerRegistry $doctrine,Request $request,int $idCampagne): Response
    {
        $campagne = $doctrine->getRepository(Campagne::Class)->find($idCampagne);
        $listeParcelle = $doctrine->getRepository(Epandage::Class)->findBy(array('campagne' => $idCampagne));
        //dump($listeParcelle);
       
        if($request->isMethod('POST')){
            $idEpandage = $_POST['idEpandage'];
            $epandage = $doctrine->getRepository(Epandage::class)->find($idEpandage);     
            $epandage->setEffectuer(0);
            $epandage->setDateEpandage(NULL);
            $em = $doctrine->getManager();
            $em->persist($epandage);
            $em->flush();
        }

        return $this->render('detail_campagne/index.html.twig', [
            'campagne'=>$campagne,
            'listeParcelle'=>$listeParcelle
        ]);
    }

    #[Route('/detail/campagne/epandage/encours/{idCampagne}', name: 'epandage_en_cours')]
    public function epandageEnCours(ManagerRegistry $doctrine,Request $request,int $idCampagne): Response
    {
        $campagne = $doctrine->getRepository(Campagne::Class)->find($idCampagne);
        $listeParcelle = $doctrine->getRepository(Epandage::Class)->findBy(array('campagne' => $idCampagne));
        //dump($listeParcelle);
       
        if($request->isMethod('POST')){
            $idEpandage = $_POST['idEpandage'];
            $epandage = $doctrine->getRepository(Epandage::class)->find($idEpandage);     
            $epandage->setEffectuer(1);
            $epandage->setDateEpandage(NULL);
            $em = $doctrine->getManager();
            $em->persist($epandage);
            $em->flush();
        }

        return $this->render('detail_campagne/index.html.twig', [
            'campagne'=>$campagne,
            'listeParcelle'=>$listeParcelle
        ]);
    }


    #[Route('/detail/campagne/epandage/export/{idCampagne}', name: 'export_excel')]
    public function excelExport(ManagerRegistry $doctrine,Request $request,int $idCampagne): Response
    {
        $campagne = $doctrine->getRepository(Campagne::Class)->find($idCampagne);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $list = [];
        $epandages = $doctrine->getRepository(Epandage::Class)->findBy(array('campagne' => $idCampagne));
        foreach ($epandages as $epandage){
            $list[] = [
                $epandage->getDateEpandage(),
                $epandage->getParcelle()->getCommune(),
                $epandage->getParcelle()->getProprietaire()->getCode(),
                $epandage->getParcelle()->getCodeNum(),
                $epandage->getParcelle()->getSuperficie(),
                $epandage->getSurfaceEpandue(),
                $epandage->getQuantite(),
                $epandage->getCulture(),
            ];
        }

        $sheet->setTitle('Epandage');
        
        $sheet->getCell('A1')->setValue($campagne->getNom());
        $sheet->getCell('A2')->setValue('Date de debut');
        $sheet->getCell('A3')->setValue('Date de fin');
        
        $sheet->getCell('A5')->setValue('Date');
        $sheet->getCell('B5')->setValue('Commune');
        $sheet->getCell('C5')->setValue('Ref AGRI');
        $sheet->getCell('D5')->setValue('Num Parcelle');
        $sheet->getCell('E5')->setValue('Surface');
        $sheet->getCell('F5')->setValue('Surface Epandue');
        $sheet->getCell('G5')->setValue('Quantite /ha');
        $sheet->getCell('H5')->setValue('Culture');


        $sheet->getCell('B2')->setValue($campagne->getDateDebut());
        $sheet->getCell('B3')->setValue($campagne->getDateFin());

        $sheet->fromArray($list,null, 'A6', true);
        $writer = new Xlsx($spreadsheet);
        $writer->save($campagne->getNom() . ".xlsx");

        $filename = $campagne->getNom() . ".xlsx";
        $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', $contentType);
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->setCallback(function() use ($writer) {
            $writer->save('php://output');
        });

        return $response;

        return $this->redirectToRoute('liste_parcelle');
    }


       

}

