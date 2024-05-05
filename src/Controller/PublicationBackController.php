<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Commentaire;
use App\Form\Publication1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\PublicationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/publication/back')]
class PublicationBackController extends AbstractController
{
    #[Route('/', name: 'app_publication_back_index', methods: ['GET'])]
    public function index(SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        $publications = $entityManager
            ->getRepository(Publication::class)
            ->findAll();

        return $this->render('publication_back/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/new', name: 'app_publication_back_new', methods: ['GET', 'POST'])]
    public function new(SessionInterface $session,Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $publication = new Publication();
        $form = $this->createForm(Publication1Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publication);
            $entityManager->flush();
            $this->sendPublicationNotificationEmail($mailer, $publication);
            
            flash()->addSuccess('Blog Added Successfully');
            return $this->redirectToRoute('app_publication_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication_back/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_back_show', methods: ['GET'])]
    public function show(SessionInterface $session,Publication $publication): Response
    {
        return $this->render('publication_back/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publication_back_edit', methods: ['GET', 'POST'])]
    public function edit(SessionInterface $session,Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Publication1Type::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            flash()->addSuccess('Blog Edited Successfully');
            return $this->redirectToRoute('app_publication_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication_back/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_back_delete', methods: ['POST'])]
    public function delete(SessionInterface $session,Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
            flash()->addSuccess('Blog Deleted Successfully');
        }

        return $this->redirectToRoute('app_publication_back_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/export-pdf', name: 'export_pdf')]
    public function exportPDF(): Response
    {
        $comments = $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
    
        // Create PDF content
        $html = '<html><body>';
        $html .= '<h1>Comments and Associated Publications</h1>';
    
        // Add comments
        foreach ($comments as $comment) {

            // Add associated publication
            $publication = $comment->getPublication();
            if ($publication) {
                $html .= '<h3>Publication:</h3>';
                $html .= '<p><strong>Title:</strong> ' . $publication->getTitre() . '</p>';
                $html .= '<p><strong>Content:</strong> ' . $publication->getContenu() . '</p>';
            } else {
                $html .= '<p>No publication.</p>';
            }
            $html .= '<h2>Comment:</h2>';
            $html .= '<p><strong>Content:</strong> ' . $comment->getContenu() . '</p>';
            $html .= '<p><strong>Date:</strong> ' . $comment->getDateCommentaire()->format('Y-m-d H:i:s') . '</p>';
    
            $html .= '<hr>';
        }
    
        $html .= '</body></html>';
    
        // Generate PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Return the PDF as a response
        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="comments_publications.pdf"',
        ]);
    }
        

    #[Route('/export-excel', name: 'export_excel')]
    public function export(SerializerInterface $serializer): Response
    {
        $publications = $this->getDoctrine()->getRepository(Publication::class)->findAll();
        $comments = $this->getDoctrine()->getRepository(Commentaire::class)->findAll();
    
        $numPublications = count($publications);
        $numComments = count($comments);
    
        $averageCommentsPerPublication = $numPublications > 0 ? $numComments / $numPublications : 0;
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        $sheet->setCellValue('A1', 'Number of Publications');
        $sheet->setCellValue('B1', $numPublications);
        $sheet->setCellValue('A2', 'Number of Comments');
        $sheet->setCellValue('B2', $numComments);
        $sheet->setCellValue('A3', 'Average Comments per Publication');
        $sheet->setCellValue('B3', $averageCommentsPerPublication);
    
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
    
        return new BinaryFileResponse($tempFile, 200, [], true);
    }

    private function sendPublicationNotificationEmail(MailerInterface $mailer, Publication $publication): void
    {
        $email = (new Email())
            ->from(new Address('PIDEV@gmail.com', 'Relcamtion'))
            ->to('mohamedazizlabidi25@gmail.com')
            ->subject('New Publication Created')
            ->html($this->renderView(
                'publication/email.html.twig',
                ['publication' => $publication]
            ));

        $mailer->send($email);

        #php bin/console messenger:consume -vv
    }

    #[Route('/search', name: 'app_publication_search', methods: ['GET'])]
    public function search(SessionInterface $session,Request $request, PublicationRepository $publicationRepository): Response
    {
        $query = $request->query->get('query');

        $publications = $publicationRepository->searchByTitleOrContent($query);

        if (!empty($publications)) {
            $publication = $publications[0];

            return $this->redirectToRoute('app_publication_back_show', ['id' => $publication->getId()]);
        }
        return $this->redirectToRoute('app_publication_back_index', [], Response::HTTP_SEE_OTHER);

    }
}
