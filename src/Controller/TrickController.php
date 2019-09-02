<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


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
     * @Route("/trick/{id}", name="trick.show")
     * @param $id
     * @param Trick $trick
     * @return Response
     */
    public function show($id, Trick $trick, CommentRepository $commentRepository, AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setUser($this->getUser());
            $this->manager->persist($comment);
            $this->manager->flush();


        }

        $comments = $commentRepository->findCommentsByTrick($trick->getId());
        $error = $authenticationUtils->getLastAuthenticationError();
        $this->repository->findOneById($id);


        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'form' => $form->createView(),
            'error' => $error,
            'display' => true

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

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('file')->getData() === null) {
                $picture = 'default-trick.jpg';
                $trick->setPicture($picture);
            } else {
                /** @var UploadedFile $file */
                $file = $form->get('file')->getData();




                move_uploaded_file($file->getLinkTarget(), ('pictures/') .$file->getFilename());
                rename(('pictures/') .$file->getFilename(), ('pictures/') .$file->getClientOriginalName());

                $pic = $file->getClientOriginalName();
                $trick->setPicture(('/pictures/').$pic);
            }




            dump($request->request->get('pictures'));
            dump($form->getData());
            $trick->setCreatedAt(new \Datetime('now', new \DateTimeZone('Europe/Paris')));

            $trick->setUser($this->getUser());

            $this->manager->persist($trick);


            $this->manager->flush();
            $this->addFlash('success', 'Trick crée avec succès');
            $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);
        }

        return $this->render('trick/add.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/delete/trick/{id}", name="delete.trick", methods="GET")
     * @param trick $trick
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Trick $trick, CommentRepository $comment)
    {
        foreach ($comment->findBy(['trick'=> $trick->getId()])as $commentEntity){
            $this->manager->remove($commentEntity);
        }

        $this->manager->remove($trick);
        $this->manager->flush();
        $this->addFlash('success', 'Trick supprimé avec succès');

        return $this->redirectToRoute('home');
    }
}
