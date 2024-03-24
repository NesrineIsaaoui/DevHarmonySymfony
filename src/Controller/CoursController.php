<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{

    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Cours::class);
        $prods = $em->findAll(); // Select * from produits;
        return $this->render('cours/index.html.twig', ['listS'=>$prods]);
    }

    #[Route('/ajouterCours', name: 'ajouterCours')]
    public function ajouterCours(Request $request): Response
    {
        $prod = new Cours(); // init objet
        $form = $this->createForm(CoursType::class, $prod);
        $form->handleRequest($request); //
        if ($form->isSubmitted() && $form->isValid()) {
            $fileUpload = $form->get('coursimage')->getData();
            $fileName = md5(uniqid()) . '.' . $fileUpload->guessExtension();
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads'; // Chemin absolu du dossier d'upload
            $fileUpload->move($uploadDir, $fileName); // Déplacer le fichier vers le dossier d'upload
            $filePath = realpath($uploadDir . '/' . $fileName); // Chemin absolu du fichier
            $prod->setCoursimage($filePath); // Stocker le chemin absolu dans l'entité
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);//ajout
            $em->flush();
            $this->addFlash(
                'notice', 'Cours a été bien ajoutée '
            );
            return $this->redirectToRoute('app_cours');
        }
        return $this->render('cours/createCours.html.twig',
            ['f' => $form->createView()]
        );
    }


    #[Route('/modifierCours/{id}', name: 'modifierCours')]
    public function modifierCours(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Cours::class)->find($id);
        $form = $this->createForm(CoursType::class, $prod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUpload = $form->get('coursimage')->getData();
            if ($fileUpload) {
                $fileName = md5(uniqid()) . '.' . $fileUpload->guessExtension(); //Cryptage image
                $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads'; // Chemin absolu du dossier d'upload
                $fileUpload->move($uploadDir, $fileName); // Déplacer le fichier vers le dossier d'upload
                $filePath = realpath($uploadDir . '/' . $fileName); // Chemin absolu du fichier
                $prod->setCoursimage($filePath);
            }

            $em->persist($prod);
            $em->flush();

            $this->addFlash(
                'notice', 'Cours a été bien modifié '
            );

            return $this->redirectToRoute('app_cours');
        }

        return $this->render('cours/modifierCours.html.twig', [
            'f' => $form->createView(),
        ]);
    }


    #[Route('/suppressionCours/{id}', name: 'suppressionCours')]
    public function suppressionCours(Cours $prod): Response
    {
        $em = $this->getDoctrine()->getManager();// ENTITY MANAGER ELY FIH FONCTIONS PREDIFINES
        $em->remove($prod);
        //MISE A JOURS
        $em->flush();
        $this->addFlash(
            'noticedelete', 'Cours a été bien supprimer '
        );

        return $this->redirectToRoute('app_cours');
    }

}
