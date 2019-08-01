<?php

namespace App\Controller;



use App\Entity\Trick;


use App\Entity\Type;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Flex\Path;

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
     * @param $id
     * @param Trick $trick
     * @return Response
     */
    public function show($id, Trick $trick, AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $this->repository->findOneById($id);



        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'error' => $error

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
            $trick->setUpdatedAt(new \Datetime('now', new \DateTimeZone('Europe/Paris')));
            $this->manager->flush();
            $this->addFlash('success', 'Trick modifié avec succès');
            return $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);

        }

        return $this->render('trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick,


        ]);
    }



    /**
     * @Route ("/add/trick", name="add.trick")
     * @param Request
     * @return Response
     */
    public function add(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $trick = new Trick();
        $form =$this-> createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick->setCreatedAt(new \Datetime('now', new \DateTimeZone('Europe/Paris')));

            $trick->setUser($this->getUser());

            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addFlash('success', 'Trick crée avec succès');
            $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);
        }
        dump($form->createView());
        return $this->render('trick/add.html.twig',[
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
}
