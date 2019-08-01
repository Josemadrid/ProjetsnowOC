<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\PropertyType;
use App\Form\TrickType;
use App\Repository\PropertyRepository;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(TrickRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.dashboard")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $tricks = $this->repository->findAll();
        return $this->render('admin/index.html.twig', compact('tricks'));
    }

    /**
     * @Route("/admin/trick/create", name= "admin.trick.new")
     */
    public function new(Request $request)
    {
        $trick = new trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($trick);
            $this->em->flush();
            $this->addFlash('success', 'Bien créer avec succès');
            return $this->redirectToRoute('admin.dashboard');
        }


        return $this->render('trick/add.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route ("/admin/trick/{id}", name="admin.trick.edit", methods="GET|POST")
     * @param trick $trick
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Trick $trick, Request $request)
    {

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.dashboard');

        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/trick/{id}", name="admin.trick.delete", methods="DELETE")
     * @param trick $trick
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete (Trick $trick) {
        $this->em->remove($trick);
        $this->em->flush();
        $this->addFlash('success', 'Bien supprimé avec succès');

        return $this->redirectToRoute('admin.dashboard');
    }





}
