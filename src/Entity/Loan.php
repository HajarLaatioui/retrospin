<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use App\Enum\LoanStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $borrowedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $returnedAt = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    private ?Vinyl $vinyl = null;

    #[ORM\Column(type: 'string', enumType: LoanStatus::class)]
    private ?LoanStatus $status = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $insuranceFee = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $price = null;

    public function __construct()
    {
        $this->borrowedAt = new \DateTimeImmutable();
        $this->status = LoanStatus::PENDING;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowedAt(): ?\DateTimeImmutable
    {
        return $this->borrowedAt;
    }

    public function setBorrowedAt(\DateTimeImmutable $borrowedAt): static
    {
        $this->borrowedAt = $borrowedAt;
        return $this;
    }

    public function getReturnedAt(): ?\DateTimeImmutable
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTimeImmutable $returnedAt): static
    {
        $this->returnedAt = $returnedAt;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getVinyl(): ?Vinyl
    {
        return $this->vinyl;
    }

    public function setVinyl(?Vinyl $vinyl): static
    {
        $this->vinyl = $vinyl;
        return $this;
    }

    public function getStatus(): ?LoanStatus
    {
        return $this->status;
    }

    public function setStatus(LoanStatus $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getInsuranceFee(): ?float
    {
        return $this->insuranceFee;
    }

    public function setInsuranceFee(?float $insuranceFee): static
    {
        $this->insuranceFee = $insuranceFee;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;
        return $this;
    }
}
