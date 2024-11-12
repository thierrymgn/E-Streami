<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DiscoverController extends AbstractController
{
    #[Route('/discover', name: 'discover')]
    public function home(CategoryRepository $categoryRepository, MediaRepository $mediaRepository): Response
    {
        return $this->render('discover.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'medias' => $mediaRepository->findTrendingMedia(3)
        ]);
    }
}