<?php

namespace App\Controller\Api;

use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class LoanApiController extends AbstractController
{
    #[Route('/loans', name: 'api_loans', methods: ['GET'])]
    public function getLoans(LoanRepository $loanRepository): JsonResponse
    {
        $loans = $loanRepository->findAll();

        $data = [];
        foreach ($loans as $loan) {
            $data[] = [
                'id' => $loan->getId(),
                'user_email' => $loan->getUser()?->getEmail(),
                'vinyl_title' => $loan->getVinyl()?->getTitle(),
                'borrowedAt' => $loan->getBorrowedAt()?->format('Y-m-d H:i'),
                'returnedAt' => $loan->getReturnedAt()?->format('Y-m-d H:i'),
                'status' => $loan->getStatus(),
                'price' => $loan->getPrice(),
                'insuranceFee' => $loan->getInsuranceFee(),
            ];
        }

        return $this->json($data);
    }
}