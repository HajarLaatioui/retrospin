<?php

namespace App\Controller\Api;

use App\Repository\VinylRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class VinylApiController extends AbstractController
{
    #[Route('/vinyls', name: 'api_vinyls', methods: ['GET'])]
    public function getVinyls(VinylRepository $vinylRepository): JsonResponse
    {
        $vinyls = $vinylRepository->findAll();

        $data = [];

        foreach ($vinyls as $vinyl) {
            $data[] = [
                'id' => $vinyl->getId(),
                'title' => $vinyl->getTitle(),
                'artist' => $vinyl->getArtist()?->getName(),
                'genre' => $vinyl->getGenre()?->getName(),
                'stock' => $vinyl->getStock(),
                'isAvailable' => $vinyl->isAvailable(),
            ];
        }

        return $this->json($data);
    }
}