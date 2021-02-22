<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\ApiFilter\JsonFilter;
use App\Repository\BeerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 *
 * @ApiResource(
 *     collectionOperations={"get"={"normalization_context"={"groups"="beer:list"}}},
 *     itemOperations={"get"={"normalization_context"={"groups"="beer:item"}}},
 *     order={"name"="DESC"},
 *     paginationEnabled=true
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"name": "exact","brewer.id": "exact","type": "exact"})
 * @ApiFilter(JsonFilter::class, properties={"country.isoCodes"})
 * @ApiFilter(RangeFilter::class, properties={"price", "pricePerLiter"})
 */
class Beer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $abv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attributes;

    /**
     * @ORM\ManyToOne(targetEntity=Brewer::class, inversedBy="beers")
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $brewer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $onSale;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $pricePerLiter;

    /**
     * @ORM\Column(type="integer", unique=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $beerId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="beers")
     *
     * @Groups({"beer:list", "beer:item"})
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(?float $abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getAttributes(): ?string
    {
        return $this->attributes;
    }

    public function setAttributes(?string $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getBrewer(): ?Brewer
    {
        return $this->brewer;
    }

    public function setBrewer(?Brewer $brewer): self
    {
        $this->brewer = $brewer;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getOnSale(): ?bool
    {
        return $this->onSale;
    }

    public function setOnSale(?bool $onSale): self
    {
        $this->onSale = $onSale;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPricePerLiter(): ?string
    {
        return $this->pricePerLiter;
    }

    public function setPricePerLiter(?string $pricePerLiter): self
    {
        $this->pricePerLiter = $pricePerLiter;

        return $this;
    }

    public function getBeerId(): ?int
    {
        return $this->beerId;
    }

    public function setBeerId(?int $beerId): self
    {
        $this->beerId = $beerId;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
