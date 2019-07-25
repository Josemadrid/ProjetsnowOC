<?php

namespace App\Controller;



use App\Entity\Trick;


use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(TrickRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/trick", name="trick.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('_form.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }
    /**
     * @Route("/trick/{id}", name="trick.show")
     * @return Response
     */
    public function show($id, Trick $trick): Response
    {
        $trick = $this->repository->findOneById($id);


        return $this->render('trick/show.html.twig', [
            'trick' => $trick

        ]);
    }


    /**
     * @Route ("/edit/trick/{id}", name="edit.trick", methods="GET|POST")
     * @param Trick $trick
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Trick $trick, Request $request)
    {

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Trick modifié avec succès');
            return $this->redirectToRoute('trick.index');

        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route ("/add/trick", name="add.trick")
     * @param Request
     * @return Response
     */
    public function add(Request $request)
    {
        $trick = new Trick();
        $form =$this-> createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addFlash('success', 'Trick crée avec succès');
            $this->redirectToRoute('trick.index');
        }
        return $this->render('trick/add.html.twig',[
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }
}
