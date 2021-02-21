<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function getFromArrayByName (?array $countries, string $name): ?Country
    {
        $foundCountry = null;

        if (!is_array($countries)) {
            return null;
        }

        foreach ($countries as $country) {
            if ($country->getName() == $name) {
                $foundCountry = $country;
                break;
            }
        }

        return $foundCountry;
    }
}
