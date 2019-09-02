<?php

namespace App\Controller\Home;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param TrickRepository $repository
     * @return Response
     */
    public function index(TrickRepository $repository): Response
    {
        $tricks = $repository->findLatest();



        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,

        ]);
    }

    /**
     * @Route("/alltricks", name="all.tricks")
     * @param TrickRepository $repository
     * @return Response
     */
    public function allTricks( TrickRepository $repository)
    {
        $alltricks = $repository->findWithMaxResult(100);

        return $this->render('home/index.html.twig', [

            'tricks' => $alltricks
        ]);
    }
}
