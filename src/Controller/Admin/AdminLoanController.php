<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use App\Enum\LoanStatus;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/loans')]
class AdminLoanController extends AbstractController
{
    #[Route('/', name: 'admin_loan_list')]
    public function list(LoanRepository $loanRepository): Response
    {
        $pendingLoans = $loanRepository->findBy(['status' => LoanStatus::PENDING]);

        foreach ($pendingLoans as $loan) {
            $start = $loan->getBorrowedAt();
            $end = $loan->getReturnedAt();

            if ($start && $end) {
                $days = $start->diff($end)->days + 1;
                $loan->setInsuranceFee(20);
                $loan->setPrice($days * 5 + 20);
            }
        }

        return $this->render('admin/loan_list.html.twig', [
            'loans' => $pendingLoans,
        ]);
    }

    #[Route('/{id}/approve', name: 'admin_loan_approve')]
    public function approve(
        Loan $loan,
        EntityManagerInterface $em,
        \App\Service\LoanManager $loanManager
    ): Response {
        $vinyl = $loan->getVinyl();
        $start = $loan->getBorrowedAt();
        $end = $loan->getReturnedAt();

        if (!$start || !$end) {
            $this->addFlash('error', 'La date de début ou de fin est manquante.');
            return $this->redirectToRoute('admin_loan_list');
        }

        if (!$loanManager->isStockAvailable($vinyl, $start, $end)) {
            if (!$vinyl->isAvailable() || $vinyl->getStock() === 0) {
                $this->addFlash('error', 'Ce vinyle n\'est plus disponible. Le stock est épuisé.');
            } else {
                $this->addFlash('error', 'Ce vinyle est déjà réservé pour les dates sélectionnées.');
            }
            return $this->redirectToRoute('admin_loan_list');
        }

        $days = $start->diff($end)->days + 1;
        $loan->setInsuranceFee(20);
        $loan->setPrice($days * 5 + 20);

        $loan->setStatus(LoanStatus::APPROVED);
        $loanManager->decrementStock($vinyl);

        $em->flush();

        return $this->redirectToRoute('admin_loan_list');
    }

    #[Route('/{id}/reject', name: 'admin_loan_reject')]
    public function reject(Loan $loan, EntityManagerInterface $em): Response
    {
        $loan->setStatus(LoanStatus::REJECTED);
        $em->flush();

        return $this->redirectToRoute('admin_loan_list');
    }
}