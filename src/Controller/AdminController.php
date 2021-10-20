<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/author/new", name="author_new")
     */
    public function newAuthor(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $this->formHandling($form, $request);
        dump($form);
        return $this->renderForm('admin/new.html.twig', ['form' => $form]);
    }
    /**
     * @param $form
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     *
     */
    private function formHandling($form, $request)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "this worked!");


            return $this->redirectToRoute('index');
        }
    }
}
