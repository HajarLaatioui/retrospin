<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Vinyl>
     */
    #[ORM\OneToMany(targetEntity: Vinyl::class, mappedBy: 'artist')]
    private Collection $vinyls;

    public function __construct()
    {
        $this->vinyls = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Vinyl>
     */
    public function getVinyls(): Collection
    {
        return $this->vinyls;
    }

    public function addVinyl(Vinyl $vinyl): static
    {
        if (!$this->vinyls->contains($vinyl)) {
            $this->vinyls->add($vinyl);
            $vinyl->setArtist($this);
        }

        return $this;
    }

    public function removeVinyl(Vinyl $vinyl): static
    {
        if ($this->vinyls->removeElement($vinyl)) {
            // set the owning side to null (unless already changed)
            if ($vinyl->getArtist() === $this) {
                $vinyl->setArtist(null);
            }
        }

        return $this;
    }
}
