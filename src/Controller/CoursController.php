<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Cours;
use App\Form\AvisType;
use App\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        $queryBuilder = $repository->createQueryBuilder('t');

        // Calculate average ratings for each course
        $averageRatings = [];
        $prods = $queryBuilder->getQuery()->getResult(); // Get all courses before pagination

        foreach ($prods as $cours) {
            $averageRating = $this->getDoctrine()->getRepository(Avis::class)->getAverageRatingForCours($cours);
            $averageRatings[$cours->getId()] = $averageRating;
        }

        $searchedCours = $request->query->get('searchedCours');

        if (!empty($searchedCours)) {
            $queryBuilder->andWhere('t.coursname LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchedCours . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1), // Current page number
            3 // Number of items per page
        );

        // Check if a new rating has been submitted
        $newRating = $request->request->get('newRating');
        $courseId = $request->request->get('courseId');
        if ($newRating !== null && $courseId !== null) {
            // Update the average rating for the specific course
            $averageRatings[$courseId] = $this->getDoctrine()->getRepository(Avis::class)->getAverageRatingForCours($repository->find($courseId));
        }

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
    #[Route('/detailCoursFront/{id}', name: 'detailCoursFront')]
    public function detailCoursFront(\Symfony\Component\HttpFoundation\Request $req, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository(Cours::class)->find($id);

        // Chemin absolu complet de l'image
        $absoluteImagePath = $prod->getCoursimage();

        // Supprimer la partie du chemin absolu correspondant au répertoire racine du projet Symfony
        $relativeImagePath = str_replace($this->getParameter('kernel.project_dir') . '/public', '', $absoluteImagePath);

        return $this->render('cours/detailCoursFront.html.twig', array(
            'id' => $prod->getId(),
            'coursname' => $prod->getCoursname(),
            'coursdescription' => $prod->getCoursdescription(),
            'coursimage' => $relativeImagePath, // Utiliser le chemin relatif ici
            'coursprix' => $prod->getCoursprix(),
            'categoryName' => $prod->getIdcategory()->getCategoryname()
        ));
    }




    #[Route('/save-rating', name: 'save_rating', methods: ['POST'])]
    public function saveRating(Request $request): Response
    {
        // Récupérer les données de la requête AJAX
        $value = $request->request->get('value');
        $courseId = $request->request->get('courseId');

        // Récupérer le cours associé à l'ID
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($courseId);

        if (!$cours) {
            // Si le cours n'est pas trouvé, retourner une réponse d'erreur
            return new Response('Course not found', Response::HTTP_NOT_FOUND);
        }

        // Créer une nouvelle instance de l'entité Avis
        $avis = new Avis();
        $avis->setEtoiles($value);
        $avis->setCours($cours);

        // Récupérer le gestionnaire d'entités de Doctrine
        $entityManager = $this->getDoctrine()->getManager();

        // Persistez l'entité dans la base de données
        $entityManager->persist($avis);
        $entityManager->flush();

        // Récupérer le nombre total d'avis pour ce cours
        $totalReviews = $this->getDoctrine()->getRepository(Avis::class)->getTotalReviewsForCours($cours);

        // Réponse à renvoyer à la requête AJAX
        return new JsonResponse(['totalReviews' => $totalReviews]);
    }

    #[Route('/Cours/tricroi', name: 'tri', methods: ['GET', 'POST'])]
    public function triCroissant(\App\Repository\CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAllSorted();

        return $this->render('cours/index.html.twig', [
            'listS' => $cours,
        ]);
    }

    #[Route('/Cours/tridesc', name: 'trid', methods: ['GET', 'POST'])]
    public function triDescroissant(\App\Repository\CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAllSorted1();

        return $this->render('cours/index.html.twig', [
            'listS' => $cours,
        ]);
    }


    #[Route('/exportExcel', name: 'exportExcel')]
    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers to the sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'COURSNAME');
        $sheet->setCellValue('C1', 'COURSDESCRIPTION');
        $sheet->setCellValue('D1', 'COURSIMAGE');
        $sheet->setCellValue('E1', 'COURSPRIX');
        $sheet->setCellValue('F1', 'COURS CATEGORIE');

        // Get the products from the database
        $products = $this->getDoctrine()->getRepository(Cours::class)->findAll();

        // Add the products to the sheet
        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->getId());
            $sheet->setCellValue('B' . $row, $product->getCoursname());
            $sheet->setCellValue('C' . $row, $product->getCoursdescription());
            $sheet->setCellValue('D' . $row, $product->getCoursimage());
            $sheet->setCellValue('E' . $row, $product->getCoursprix());
            $sheet->setCellValue('F' . $row, $product->getIdcategory()->getCategoryname());

            $row++;
        }


        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'cours.xlsx';
        $writer->save($filename);

        // Return the Excel file as a response
        return $this->file($filename);
    }


}
