<?php

namespace App\Entity;

use App\Repository\VinylRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: VinylRepository::class)]
class Vinyl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $releaseYear = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\ManyToOne(inversedBy: 'vinyls')]
    private ?Artist $artist = null;

    #[ORM\ManyToOne(inversedBy: 'vinyls')]
    private ?Genre $genre = null;

    #[ORM\OneToMany(mappedBy: 'vinyl', targetEntity: Loan::class)]
    private Collection $loans;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 10])]
    private ?int $stock = 10;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 5])]
    private float $dailyPrice = 5.0;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 20])]
    private float $insuranceFee = 20.0;

    public function __construct()
    {
        $this->loans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    public function getDailyPrice(): float
    {
        return $this->dailyPrice;
    }

    public function setDailyPrice(float $dailyPrice): static
    {
        $this->dailyPrice = $dailyPrice;
        return $this;
    }

    public function getInsuranceFee(): float
    {
        return $this->insuranceFee;
    }

    public function setInsuranceFee(float $insuranceFee): static
    {
        $this->insuranceFee = $insuranceFee;
        return $this;
    }
    public function hasStock(): bool
    {
        return $this->stock !== null && $this->stock > 0;
    }

    public function getLoans(): Collection
    {
        return $this->loans;
    }

    public function addLoan(Loan $loan): static
    {
        if (!$this->loans->contains($loan)) {
            $this->loans->add($loan);
            $loan->setVinyl($this);
        }
        return $this;
    }

    public function removeLoan(Loan $loan): static
    {
        if ($this->loans->removeElement($loan)) {
            if ($loan->getVinyl() === $this) {
                $loan->setVinyl(null);
            }
        }
        return $this;
    }
}
