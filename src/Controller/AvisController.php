<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{


    #[Route('/avis', name: 'app_avis')]
    public function affichageAvis(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Avis::class);
        $avis = $em->findAll();
        return $this->render('avis/index.html.twig', ['avis' => $avis]);
    }
    #[Route('/ajoutAvis', name: 'ajoutAvis')]
    public function ajoutAvis(Request $request): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
            $this->addFlash(
                'notice', 'Avis a été bien ajoutée !'
            );
            return $this->redirectToRoute('app_avis');
        }
        return $this->render('avis/addCoursAvis.html.twig',
            ['f' => $form->createView()]
        );
    }
    #[Route('/modifierAvis/{id}', name: 'modifierAvis')]
    public function modifierAvis(Request $request, $id): Response
    {
        $prod = $this->getDoctrine()->getManager()->getRepository(Avis::class)->find($id);
        $form = $this->createForm(AvisType::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);//ajout
            $em->flush();// commit
            $this->addFlash(
                'notice', 'Avis a été bien modifiée ! '
            );
            return $this->redirectToRoute('app_avis');
        }
        return $this->render('avis/modifierAvis.html.twig',
            ['f' => $form->createView()]
        );
    }
    #[Route('/supprimerAvis/{id}', name: 'supprimerAvis')]
    public function supprimerAvis(Avis $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        //MISE A JOUR
        $em->flush();//commit
        $this->addFlash(
            'noticedelete', 'Avis a été bien supprimé '
        );
        return $this->redirectToRoute('app_avis');
    }


}
