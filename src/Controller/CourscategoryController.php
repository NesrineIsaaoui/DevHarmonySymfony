<?php

namespace App\Controller;

use App\Entity\Courscategory;
use App\Form\CourscategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourscategoryController extends AbstractController
{
    #[Route('/', name: 'app_category')]
    public function affichageCategories(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Courscategory::class);
        $categories = $em->findAll();
        return $this->render('courscategory/index.html.twig', ['cat' => $categories]);
    }
    #[Route('/ajoutCategorie', name: 'ajout_category')]
    public function ajoutCategorie(Request $request): Response
    {
        $category = new Courscategory();
        $form = $this->createForm(CourscategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash(
                'notice', 'Category a été bien ajoutée !'
            );
            return $this->redirectToRoute('app_category');
        }
        return $this->render('courscategory/addCoursCategory.html.twig',
            ['f' => $form->createView()]
        );
    }
    #[Route('/modifierCategorie/{id}', name: 'modifier_category')]
    public function modifierCategory(Request $request, $id): Response
    {
        $prod = $this->getDoctrine()->getManager()->getRepository(Courscategory::class)->find($id);
        $form = $this->createForm(CourscategoryType::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);//ajout
            $em->flush();// commit
            $this->addFlash(
                'notice', 'Category a été bien modifiée ! '
            );
            return $this->redirectToRoute('app_category');
        }
        return $this->render('courscategory/modifierCategory.html.twig',
            ['f' => $form->createView()]
        );
    }
    #[Route('/supprimerCategorie/{id}', name: 'supprimerCategory')]
    public function supprimerCategory(Courscategory $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        //MISE A JOUR
        $em->flush();//commit
        $this->addFlash(
            'noticedelete', 'Category a été bien supprimé '
        );
        return $this->redirectToRoute('app_category');
    }

}