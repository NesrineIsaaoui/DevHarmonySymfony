<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\User1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use App\Form\User2Type;
=======
>>>>>>> 877c365e6de165875e91361e27f8d158d37b1f4a

#[Route('/user/back')]
class UserBackController extends AbstractController
{
    #[Route('/', name: 'app_user_back_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        // Count users by role using findBy method
        $studentsCount = count($userRepository->findBy(['role' => 'Enseignant']));
        $teachersCount = count($userRepository->findBy(['role' => 'Etudiant']));
        // Get all users (optional, depending on your requirements)
        $users = $userRepository->findAll();

        // Calculate the percentage of students among all users
        $totalUsers = count($users);
        $studentsPercentage = $totalUsers > 0 ? ($studentsCount / $totalUsers) * 100 : 0;

        return $this->render('user_back/index.html.twig', [
            'users' => $users,
            'studentsCount' => $studentsCount,
            'teachersCount' => $teachersCount,
            'studentsPercentage' => $studentsPercentage,
            'totalUsers' => $totalUsers,
        ]);
    }

    #[Route('/new', name: 'app_user_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }

                // Update the 'image' property to store the file name
                $user->setImage($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_back/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_back_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user_back/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        $form = $this->createForm(User2Type::class, $user);
=======
        $form = $this->createForm(User1Type::class, $user);
>>>>>>> 877c365e6de165875e91361e27f8d158d37b1f4a
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_back/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_back_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
