<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    /**
     * @var TrickRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(CommentRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/comment", name="comment")
     */
    public function addComment($id, Trick $trick, Request $request): Response
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
            return $this->redirectToRoute('trick.show', ['id' => $trick->getId(), '_fragment' => $comment->getId()]);


        }

        return $this->render('trick/show.html.twig', [
            'comments' => $comments,
            'trick' => $trick,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/allcomments/{id},", name="all.comments", methods="GET|POST")
     * @param CommentRepository $repository
     * @return Response
     */
    public function allTricks($id, TrickRepository $trickRepository, CommentRepository $repository, Request $request)
    {
        $comment = new Comment();
        $allcomments = $repository->findWithMaxResult(100, $id);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setUser($this->getUser());
            $this->manager->persist($comment);
            $this->manager->flush();


        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trickRepository->findOneById($id),
            'comments' => $allcomments,
            'form' => $form->createView(),
            'display' => false
        ]);
    }
}
