<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @Route("/trick/{id}", name="trick.show", methods="GET|POST")
     * @param $id
     * @param Trick $trick
     * @return Response
     */
    public function show($id, Trick $trick, PictureRepository $pictureRepository, VideoRepository $videoRepository, CommentRepository $commentRepository, AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setCreatedAt((new \Datetime('now', new \DateTimeZone('Europe/Paris'))))
                ->setTrick($trick)
                ->setUser($this->getUser());
            $this->manager->persist($comment);
            $this->manager->flush();


        }

        $pictures = $pictureRepository->findBy(array('trick' => $trick->getId()));
        $videos = $videoRepository->findBy(array('trick' => $trick->getId()));
        $comments = $commentRepository->findCommentsByTrick($trick->getId());
        $error = $authenticationUtils->getLastAuthenticationError();
        $this->repository->findOneById($id);


        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'pictures' => $pictures,
            'videos' => $videos,
            'comments' => $comments,
            'form' => $form->createView(),
            'error' => $error,
            'display' => true


        ]);
    }


    /**
     * @Route ("/edit/trick/{id}", name="edit.trick", methods="GET|POST")
     * @param Trick $trick
     * @param PictureRepository $pictureRepository
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @return Response
     * @throws \Exception
     */
    public function edit(Trick $trick, PictureRepository $pictureRepository, Request $request, VideoRepository $videoRepository)
    {

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if ($file !== null)
            {
                move_uploaded_file($file->getLinkTarget(), ('pictures/') . $file->getFilename());
                rename(('pictures/') . $file->getFilename(), ('pictures/') . $file->getClientOriginalName());
                $pic = $file->getClientOriginalName();
                $trick->setPicture(('/pictures/') . $pic);
            }

            /** @var ArrayCollection $arrayCollectionPictures */
            $arrayCollectionPictures = $form->get('pictures')->getData();

            /** @var Picture $picture */
            foreach ($arrayCollectionPictures->getValues() as $picture) {

                /** @var UploadedFile $img */
                $img = $picture->getPicture();
                if ($img) {
                    $fileName = '/pictures/' . md5(uniqid()) . '.' . $img->guessExtension();
                    $img->move($this->getParameter('upload_directory'), $fileName);
                    $picture->setName($fileName);
                    $picture->setPicture($img);
                    $trick->addPicture($picture);

                }




            }
            /** @var ArrayCollection $arraCollectionVideos */
            $arraCollectionVideos = $form->get('videos')->getData();


            foreach ($arraCollectionVideos->getValues() as $video) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->getUrl(), $match)) {
                    $video->setUrl('https://www.youtube.com/embed/' . $match[1]);
                    $trick->addVideo($video);
                }
            }

            $trick->setUpdatedAt(new \Datetime('now', new \DateTimeZone('Europe/Paris')));
            $this->manager->flush();
            $this->addFlash('success', 'Trick modifié avec succès');
            return $this->redirectToRoute('trick.show', ['id' => $trick->getId()]);

        }
        $pictures = $pictureRepository->findBy(array('trick' => $trick->getId()));
        $videos = $videoRepository->findBy(array('trick' => $trick->getId()));
        dump($trick->getVideos());

        return $this->render('trick/edit.html.twig', ['form' => $form->createView(),
            'trick' => $trick,
            'pictures' => $pictures,
            'videos' => $videos,
            'display' => true]);
    }


    /**
     * @Route ("/add/trick", name="add.trick", methods="GET|POST")
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




            /** @var ArrayCollection $arrayCollectionPictures */
            $arrayCollectionPictures = $form->get('pictures')->getData();


            /** @var Picture $picture */
            foreach ($arrayCollectionPictures->getValues() as $picture) {
                /** @var UploadedFile $img */
                $img = $picture->getPicture();
                $fileName = '/pictures/' . md5(uniqid()) . '.' . $img->guessExtension();
                $img->move($this->getParameter('upload_directory'), $fileName);
                $picture->setName($fileName);
                $picture->setPicture($img);
                $trick->addPicture($picture);

            }


            foreach ($trick->getVideos() as $video) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video->getUrl(), $match)) {
                    $video_id = $match[1];
                    $video->setUrl('https://www.youtube.com/embed/' . $video_id);
                }
            }

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            if ($file === null){
                $image = '/pictures/default-trick.jpg';
                $trick->setPicture($image);
            } else{
                move_uploaded_file($file->getLinkTarget(), ('pictures/') . $file->getFilename());
                rename(('pictures/') . $file->getFilename(), ('pictures/') . $file->getClientOriginalName());

                $pic = $file->getClientOriginalName();
                $trick->setPicture(('/pictures/') . $pic);
            }




            $trick->setCreatedAt(new \Datetime('now', new \DateTimeZone('Europe/Paris')));
            $trick->setUser($this->getUser());
            $this->manager->persist($trick);
            $this->manager->flush();
            $this->addFlash('success', 'Trick crée avec succès');
            return $this->redirectToRoute('all.tricks');
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
    public
    function delete(Trick $trick, VideoRepository $videoRepository, CommentRepository $comment, PictureRepository $pictureRepository)
    {
        foreach ($comment->findBy(['trick' => $trick->getId()]) as $commentEntity) {
            $this->manager->remove($commentEntity);
        }
        foreach ($pictureRepository->findBy(['trick' => $trick->getId()]) as $pictureEntity) {
            $this->manager->remove($pictureEntity);
        }

        foreach ($videoRepository->findBy(['trick' => $trick->getId()]) as $videoEntity) {
            $this->manager->remove($videoEntity);
        }

        $this->manager->remove($trick);
        $this->manager->flush();
        $this->addFlash('success', 'Trick supprimé avec succès');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/delete/video/{id}", name="delete.video", methods="GET")
     * @param Video $video
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public
    function deletevideo(Video $video)
    {

        $this->manager->remove($video);
        $this->manager->flush();
        $this->addFlash('success', 'Video supprimé avec succès');

        return $this->redirectToRoute('edit.trick', ['id' => $video->getTrick()->getId()]);

    }

    /**
     * @Route("/delete/picture/{id}", name="delete.picture", methods="GET")
     * @param Picture $picture
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletepicture(Picture $picture)
    {

        $this->manager->remove($picture);
        $this->manager->flush();
        $this->addFlash('success', ' Image supprimé avec succès');

        return $this->redirectToRoute('edit.trick', ['id' => $picture->getTrick()->getId()]);

    }

}
