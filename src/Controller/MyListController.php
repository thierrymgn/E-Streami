<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyListController extends AbstractController
{
    #[Route('/lists', name: 'show_my_list')]
    public function discover_category(
        Request $request,
        PlaylistRepository $playlistRepository, 
        PlaylistSubscriptionRepository $playlistSubscriptionRepository
        ): Response
    {
        $playlistId = $request->query->get('playlistId');
        $currentPlaylist = null;

        if (isset($playlistId) && !empty($playlistId)) {
            $currentPlaylist = $playlistRepository->find($playlistId);
            
            if ($currentPlaylist === null) {
                throw new \Exception("Playlist with id $playlistId not found.");
            }
        }

        return $this->render('lists.html.twig', [
            'playlists' => $playlistRepository->findAll(),
            'playlistSubscriptions' => $playlistSubscriptionRepository->findAll(),
            'currentPlaylist' => $currentPlaylist
        ]);
    }
}