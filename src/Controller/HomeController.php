<?php

namespace App\Controller;

use App\Repository\VinylRepository;
use App\Repository\LoanRepository;
use App\Enum\LoanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(VinylRepository $vinylRepository, LoanRepository $loanRepository): Response
    {
        $vinyls = $vinylRepository->createQueryBuilder('v')
            ->where('v.isAvailable = true')
            ->andWhere('v.stock > 0')
            ->getQuery()
            ->getResult();
        $loans = $loanRepository->findBy(['status' => LoanStatus::APPROVED]);

        return $this->render('home/index.html.twig', [
            'vinyls' => $vinyls,
            'loans' => $loans,
        ]);
    }
    
}
