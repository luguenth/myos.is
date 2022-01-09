<?php

namespace App\Controller;

use App\Entity\Aiku;
use App\Form\AikuType;
use App\Repository\AikuRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AikuController extends AbstractController
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(AikuRepository $aikuRepository): Response
    {
        $aikus = $aikuRepository->findAll();
        return $this->render('aiku/index.html.twig', [
            'controller_name' => 'AikuController',
            'all_aikus' => $aikus
        ]);
    }

    /**
     * @param $id
     * @param AikuRepository $aikuRepository
     * @return Response
     *
     * @Route("/{id}", name="aiku_detail", requirements={"id"="\d+"})
     */
    public function detail($id, AikuRepository $aikuRepository)
    {
        $aiku = $aikuRepository->find($id);
        return $this->render('aiku/detail.html.twig', [
            'aiku' => $aiku,
        ]);
    }

    /**
     * @param AikuRepository $aikuRepository
     * @return Response
     *
     * @Route("/aiku/new", name="aiku_new")
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $aiku = new Aiku();
        $form = $this->createForm(AikuType::class, $aiku);

        $this->formHandling($form, $request);

        return $this->renderForm('aiku/new.html.twig', ['form' => $form]);
    }

    /**
     * @param AikuRepository $aikuRepository
     * @return Response
     *
     * @Route("/aiku/{id}/edit", name="aiku_edit")
     */
    public function edit($id, Request $request, AikuRepository $aikuRepository): Response
    {
        $aiku = $aikuRepository->find($id);
        $form = $this->createForm(AikuType::class, $aiku);

        $this->formHandling($form, $request);

        return $this->renderForm('aiku/new.html.twig', ['form' => $form]);
    }

    public function like($id, AikuRepository $aikuRepository)
    {
        $aiku = $aikuRepository->find($id);
        $aiku->setLikes($aiku->getLikes() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($aiku);
        $em->flush();
        return $this->redirectToRoute('aiku_detail', ['id' => $id]);
    }

    /**
     * @param $id
     * @param AikuRepository $aikuRepository
     * @return Response
     *
     * @Route("/aiku/{id}/delete", name="aiku_delete")
     */
    public function delete($id, AikuRepository $aikuRepository): Response
    {
        $aiku = $aikuRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($aiku);
        $em->flush();
        return $this->redirectToRoute('index');
    }

    private function formHandling($form, $request): void
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Aiku $aiku */
            $aiku = $form->getData();

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/assets/img';
                $origFileName = uniqid('', true) . $uploadedFile->getClientOriginalName();
                $uploadedFile->move($destination, $origFileName);
                $aiku->setImagePath($origFileName);
            }
            $author = $this->userRepository->find($form['author']->getData());
            $aiku->setAuthor($author);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aiku);
            $entityManager->flush();
            $this->addFlash('success', "this worked!");


            $this->redirectToRoute('index');
        }
    }

}
