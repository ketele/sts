<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BrewerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BrewerRepository::class)
 *
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="brewer:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="brewer:item"}}},
 *     order={"name"="DESC"},
 *     paginationEnabled=true
 * )
 */
class Brewer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"brewer:list", "brewer:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Groups({"brewer:list", "brewer:item"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Beer::class, mappedBy="brewer")
     */
    private $beers;

    /**
     * @Groups({"brewer:list", "brewer:item"})
     */
    private $beersCount;

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

    /**
     * @return Collection|Beer[]
     */
    public function getBeers(): Collection
    {
        return $this->beers;
    }

    public function getBeersCount(): ?int
    {
        $this->beersCount = $this->beers->count();
        return $this->beersCount;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->beers->contains($beer)) {
            $this->beers[] = $beer;
            $beer->setBrewer($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->beers->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getBrewer() === $this) {
                $beer->setBrewer(null);
            }
        }

        return $this;
    }
}
