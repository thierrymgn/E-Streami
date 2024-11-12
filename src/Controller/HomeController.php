<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(MediaRepository $mediaRepository): Response
    {
        return $this->render('home.html.twig', [
            'medias' => $mediaRepository->findTrendingMedia(9)
        ]);
    }
}