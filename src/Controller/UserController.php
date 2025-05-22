<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    #[Route('/mes-prets', name: 'user_loans')]
    #[IsGranted('ROLE_USER')]
    public function loans(LoanRepository $loanRepository): Response
    {
        $user = $this->getUser();
        $loans = $loanRepository->findBy(['user' => $user]);

        return $this->render('user/loans.html.twig', [
            'loans' => $loans,
        ]);
    }
}