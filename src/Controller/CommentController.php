<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{


    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {

        $this->manager = $manager;
    }

    /**
     * @Route("/comment", name="comment", methods="GET|POST")
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
     * @param $id
     * @param PictureRepository $pictures
     * @param TrickRepository $trickRepository
     * @param CommentRepository $repository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function allTricks($id, PictureRepository $pictureRepository, TrickRepository $trickRepository, CommentRepository $repository, VideoRepository $videoRepository, Request $request)
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
        $trick = $trickRepository->findOneById($id);
        $pictures = $pictureRepository->findBy(array('trick' => $trick->getId()));
        $videos = $videoRepository->findBy(array('trick' => $trick->getId()));


        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'videos' => $videos,
            'comments' => $allcomments,
            'pictures' => $pictures,
            'form' => $form->createView(),
            'display' => false
        ]);
    }
}
