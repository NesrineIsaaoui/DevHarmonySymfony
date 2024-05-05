<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Plan; // Import the Plan entity
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;


class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="display_task")
     */
    public function index(): Response
    {
        $tasks = $this->getDoctrine()->getManager()->getRepository(Task::class)->findAll();
        return $this->render('task/index.html.twig', [
            't'=>$tasks
        ]);
    }

    /**
     * @Route("/addTask", name="addTask")
     */
    public function addTask(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, [
            'plans' => $this->getDoctrine()->getRepository(Plan::class)->findAll(), // Pass available plans
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('display_task');
        }
        return $this->render('task/createTask.html.twig',['f1'=>$form->createView()]);
    }

    /**
     * @Route("/removeTask/{id}", name="supp_task")
     */
    public function suppressionPlan(Task $task): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('display_task');
    }

    /**
     * @Route("/modifTask/{id}", name="modifTask")
     */
    public function modifTask(Request $request, $id): Response
    {
        $task = $this->getDoctrine()->getManager()->getRepository(Task::class)->find($id);

        $form = $this->createForm(TaskType::class, $task, [
            'plans' => $this->getDoctrine()->getRepository(Plan::class)->findAll(), // Pass available plans
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('display_task');
        }
        return $this->render('task/updateTask.html.twig',['f1'=>$form->createView()]);
    }
}
