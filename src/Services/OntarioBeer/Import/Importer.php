<?php

namespace App\Services\OntarioBeer\Import;

use App\Entity\Beer;
use App\Entity\Brewer;
use App\Repository\BeerRepository;
use App\Repository\BrewerRepository;
use App\Repository\CountryRepository;

class Importer
{
    private $beerRepository;
    private $brewerRepository;
    private $countryRepository;

    private $countries;

    public function __construct(
        BeerRepository $beerRepository,
        BrewerRepository $brewerRepository,
        CountryRepository $countryRepository
    ) {
        $this->beerRepository = $beerRepository;
        $this->brewerRepository = $brewerRepository;
        $this->countryRepository = $countryRepository;

        $this->countries = $countryRepository->findAll();
    }

    public function importBeer(\stdClass $beer): void
    {
        $brewer = $this->brewerRepository->findOneBy(['name' => $beer->brewer]);
        if (!$brewer) {
            $brewer = new Brewer();
            $brewer->setName($beer->brewer);
            $this->brewerRepository->save($brewer);
        }

        $beerEntity = $this->beerRepository->findOneBy(['beerId' => $beer->beer_id]);
        if (!$beerEntity) {
            $beerEntity = new Beer();
        }

        $beerEntity->setBeerId($beer->beer_id);
        $beerEntity->setAbv($beer->abv);
        $beerEntity->setAttributes($beer->attributes);
        $beerEntity->setBrewer($brewer);
        $beerEntity->setCategory($beer->category);
        $beerEntity->setCountry($this->countryRepository->getFromArrayByName($this->countries, $beer->country));
        $beerEntity->setImageUrl($beer->image_url);
        $beerEntity->setOnSale($beer->on_sale);
        $beerEntity->setPrice($beer->price);
        $beerEntity->setPricePerLiter($this->calculatePricePerLiter($beer->price, $this->sizeToLiter($beer->size)));
        $beerEntity->setSize($beer->size);
        $beerEntity->setStyle($beer->style);
        $beerEntity->setType($beer->type);
        $beerEntity->setName($beer->name);
        $beerEntity->setProductId($beer->product_id);

        $this->beerRepository->save($beerEntity);
    }

    protected function sizeToLiter(string $sizeText): float
    {
        $pattern = '/(\d+)\D+(\d+)\s*((\w[^(NEW)])+)/u';
        $multiplier = 0.001;

        preg_match_all($pattern, $sizeText, $matches);
        $number = $matches[1][0];
        $volume = $matches[2][0];
        $unit = $matches[3][0];

        if (!is_numeric($number)) {
            return null;
        }

        if (!is_numeric($volume)) {
            return null;
        }

        if ($unit !== 'ml') {
            return null;
        }
        // ToDo: Exceptions
        $liter = $number * $volume * $multiplier;

        return $liter;
    }

    private function calculatePricePerLiter($price, $volume): float
    {
        // ToDo: 0 exception
        return ($volume != 0)
            ? (1 / $volume) * $price
            : null;
    }
}