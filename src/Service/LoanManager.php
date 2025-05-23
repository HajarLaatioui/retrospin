<?php

namespace App\Service;

use App\Entity\Loan;
use App\Entity\Vinyl;
use App\Enum\LoanStatus;
use App\Repository\LoanRepository;

class LoanManager
{
    public function __construct(private LoanRepository $loanRepository) {}

    public function isStockAvailable(Vinyl $vinyl, \DateTimeImmutable $start, \DateTimeImmutable $end): bool
    {
        if (!$vinyl->isAvailable()) {
            return false;
        }

        $approvedLoans = $this->loanRepository->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->where('l.vinyl = :vinyl')
            ->andWhere('l.status = :status')
            ->andWhere('(
                (:start BETWEEN l.borrowedAt AND l.returnedAt) OR
                (:end BETWEEN l.borrowedAt AND l.returnedAt) OR
                (l.borrowedAt BETWEEN :start AND :end)
            )')
            ->setParameter('vinyl', $vinyl)
            ->setParameter('status', LoanStatus::APPROVED)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getSingleScalarResult();

        return $approvedLoans < $vinyl->getStock();
    }

    public function calculatePrice(\DateTimeImmutable $start, \DateTimeImmutable $end, float $ratePerDay): float
    {
        $days = (int) $start->diff($end)->format('%a') + 1;
        return $days * $ratePerDay;
    }

    public function calculateTotalWithInsurance(float $price, float $insuranceFee): float
    {
        return $price + $insuranceFee;
    }

    public function decrementStock(Vinyl $vinyl): void
    {
        $vinyl->setStock($vinyl->getStock() - 1);
    }
}