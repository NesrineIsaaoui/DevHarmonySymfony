<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Questionquiz;
use App\Entity\Questiontest;
use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Quiz ;

/**
 * @Route("/quiz_admin")
 */
class QuizAndTestAdminController extends AbstractController
{
    /**
     * @Route("/", name="quiz_and_test_admin")
     */
    public function index(): Response
    {
        $search = "";
        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findAll() ;
        $test = $this->getDoctrine()->getRepository(Test::class)->findAll() ;

        return $this->render('quiz_and_test_admin/index.html.twig', [
            'quizzes' =>  $quizzes,
            'search' => $search ,
             'tests'=>$test ,
        ]);
    }

    /**
     * @Route("/showQuiz/{id}", name="quiz_admin_show", methods={"GET","POST"})
     * @param $id
     * @return Response
     */
    public function showQuiz($id): Response
    {
        $questions = $this->getDoctrine()->getRepository(Questionquiz::class)
            ->findBy(array('idQuiz'=>$id)) ;

        return $this->render('quiz_and_test_admin/show_quiz.html.twig', [
            'quiz' => $this->getDoctrine()->getRepository(Quiz::class)->find($id),
            'questionquizzes' => $questions,
        ]);
    }

    /**
     * @Route("/showTest/{id}", name="test_admin_show", methods={"GET","POST"})
     * @param $id
     * @return Response
     */
    public function showTest($id): Response
    {
        $questions = $this->getDoctrine()->getRepository(Questiontest::class)
            ->findBy(array('idTest'=>$id)) ;
        $test = $this->getDoctrine()->getRepository(Test::class)->find($id) ;
        $notes = $this->getDoctrine()->getRepository(Note::class)
            ->findBy(array('idTest'=>$id)) ;

        return $this->render('quiz_and_test_admin/show_test.html.twig', [
            'test' => $test ,
            'questiontest' => $questions,
            'notes' => $notes,
        ]);
    }
}
