<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Form\PlanType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanController extends AbstractController
{
    /**
     * @Route("/plan", name="display_plan")
     */
    public function index(): Response
    {
        $plans = $this->getDoctrine()->getManager()->getRepository(Plan::class)->findAll();
        return $this->render('plan/index.html.twig', [
           'p'=>$plans
        ]);
    }

        /**
     * @Route("/addPlan", name="addPlan")
     */
    public function addPlan(Request $request): Response
    {
        $plan = new Plan();
        $form = $this->createForm(PlanType::class, $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plan);//Add
            $em->flush();

            return $this->redirectToRoute('display_plan');
        }
        return $this->render('plan/createPlan.html.twig',['f'=>$form->createView()]);




    }

      /**
     * @Route("/removePlan/{id}", name="supp_plan")
     */
    public function suppressionPlan(Plan  $plan): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($plan);
        $em->flush();

        return $this->redirectToRoute('display_plan');
    }

     /**
     * @Route("/modifPlan/{id}", name="modifPlan")
     */
    public function modifPlan(Request $request,$id): Response
    {
        $plan = $this->getDoctrine()->getManager()->getRepository(Plan::class)->find($id);

        $form = $this->createForm(PlanType::class,$plan);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('display_plan');
        }
        return $this->render('plan/updatePlan.html.twig',['f'=>$form->createView()]);




    }
}
