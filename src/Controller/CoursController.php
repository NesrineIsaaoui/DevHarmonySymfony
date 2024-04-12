<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Cours;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class CoursController extends AbstractController
{

    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Cours::class);
        $prods = $em->findAll(); // Select * from produits;
        return $this->render('cours/index.html.twig', ['listS' => $prods]);
    }
    #[Route('/coursFront', name: 'coursFront')]
    public function coursFront(Request $request, PaginatorInterface $paginator): Response
    {
        $repository = $this->getDoctrine()->getRepository(Cours::class);
        $prods = $repository->findAll(); // Select * from cours;
        $searchedCours = $request->query->get('searchedCours');
        $queryBuilder = $repository->createQueryBuilder('t');
        // Calculate average ratings for each course
        $averageRatings = [];
        foreach ($prods as $cours) {
            $averageRating = $this->getDoctrine()->getRepository(Avis::class)->getAverageRatingForCours($cours);
            $averageRatings[$cours->getId()] = $averageRating;
        }
        if (!empty($searchedCours)) {
            $queryBuilder->andWhere('t.coursname LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchedCours . '%');
        }

        $query = $queryBuilder->getQuery();
        $pagination = $paginator->paginate(
            $prods,
            $request->query->getInt('page', 1), // Current page number
            3 // Number of items per page
        );

        return $this->render('cours/coursFront.html.twig', [
            'listS' => $pagination,
            'averageRatings' => $averageRatings,
            'searchedCours' => $searchedCours,

        ]);
    }

    #[Route('/ajouterCours', name: 'ajouterCours')]
    public function ajouterCours(Request $request): Response
    {
        $prod = new Cours(); // Initialisation de l'objet Cours
        $form = $this->createForm(CoursType::class, $prod); // Création du formulaire
        $form->handleRequest($request); // Gestion de la requête

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier téléchargé
            $fileUpload = $form->get('coursimage')->getData();

            // Générer un nom de fichier unique
            $fileName = md5(uniqid()) . '.' . $fileUpload->guessExtension();

            // Définir le chemin absolu complet pour sauvegarder le fichier
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';

            // Déplacer le fichier téléchargé vers le dossier uploads
            $fileUpload->move($uploadDir, $fileName);

            // Enregistrer le chemin relatif du fichier dans la base de données
            $filePath = '/uploads/' . $fileName;
            $prod->setCoursimage($filePath);

            // Enregistrer l'objet dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();

            $this->addFlash('notice', 'Le cours a été ajouté avec succès.');

            return $this->redirectToRoute('app_cours');
        }

        return $this->render('cours/createCours.html.twig', [
            'f' => $form->createView()
        ]);
    }

    #[Route('/modifierCours/{id}', name: 'modifierCours')]
    public function modifierCours(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Cours::class)->find($id);
        $form = $this->createForm(CoursType::class, $prod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier téléchargé
            $fileUpload = $form->get('coursimage')->getData();

            // Générer un nom de fichier unique
            $fileName = md5(uniqid()) . '.' . $fileUpload->guessExtension();

            // Définir le chemin absolu complet pour sauvegarder le fichier
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';

            // Déplacer le fichier téléchargé vers le dossier uploads
            $fileUpload->move($uploadDir, $fileName);

            // Enregistrer le chemin relatif du fichier dans la base de données
            $filePath = '/uploads/' . $fileName;
            $prod->setCoursimage($filePath);

            // Enregistrer l'objet dans la base de données
            $em = $this->getDoctrine()->getManager();
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

    #[Route('/detailCours/{id}', name: 'detailCours')]
    public function detailCours(\Symfony\Component\HttpFoundation\Request $req, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Cours::class)->find($id);

        // Chemin absolu complet de l'image
        $absoluteImagePath = $prod->getCoursimage();

        // Supprimer la partie du chemin absolu correspondant au répertoire racine du projet Symfony
        $relativeImagePath = str_replace($this->getParameter('kernel.project_dir') . '/public', '', $absoluteImagePath);

        return $this->render('cours/detailCours.html.twig', array(
            'id' => $prod->getId(),
            'coursname' => $prod->getCoursname(),
            'coursdescription' => $prod->getCoursdescription(),
            'coursimage' => $relativeImagePath, // Utiliser le chemin relatif ici
            'coursprix' => $prod->getCoursprix(),
            'categoryName' => $prod->getIdcategory()->getCategoryname()
        ));
    }


}