<?php

namespace App\Tests\Service;

use App\Service\LoanManager;
use PHPUnit\Framework\TestCase;

class LoanManagerTest extends TestCase
{
    public function testCalculatePriceSimple(): void
    {
        $loanManager = new LoanManager($this->createMock(\App\Repository\LoanRepository::class));
        $start = new \DateTimeImmutable('2025-05-01');
        $end = new \DateTimeImmutable('2025-05-05');
        $ratePerDay = 5;
        $price = $loanManager->calculatePrice($start, $end, $ratePerDay);
        $this->assertEquals(25, $price);
    }

    public function testDecrementStock(): void
    {
        $vinyl = $this->getMockBuilder(\App\Entity\Vinyl::class)
                      ->onlyMethods(['getStock', 'setStock'])
                      ->getMock();
        $vinyl->expects($this->once())
              ->method('getStock')
              ->willReturn(10);
        $vinyl->expects($this->once())
              ->method('setStock')
              ->with($this->equalTo(9));
        $loanManager = new LoanManager($this->createMock(\App\Repository\LoanRepository::class));
        $loanManager->decrementStock($vinyl);
    }
}