<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 *
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="country:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="country:item"}}},
 *     order={"name"="DESC"},
 *     paginationEnabled=true
 * )
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"country:list", "country:item"})
     */
    private $name;

    /**
     * @ORM\Column(type="json")
     *
     * @Groups({"country:list", "country:item"})
     */
    private $isoCodes = [];

    /**
     * @ORM\OneToMany(targetEntity=Beer::class, mappedBy="country")
     */
    private $beers;

    public function __construct()
    {
        $this->beers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoCodes(): ?array
    {
        return $this->isoCodes;
    }

    public function setIsoCodes(array $isoCodes): self
    {
        $this->isoCodes = $isoCodes;

        return $this;
    }

    /**
     * @return Collection|Beer[]
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->beers->contains($beer)) {
            $this->beers[] = $beer;
            $beer->setCountry($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->beers->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getCountry() === $this) {
                $beer->setCountry(null);
            }
        }

        return $this;
    }
}
