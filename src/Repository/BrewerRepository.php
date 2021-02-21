<?php

namespace App\Repository;

use App\Entity\Brewer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Brewer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewer[]    findAll()
 * @method Brewer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrewerRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct($registry, Brewer::class);
    }

    public function save(Brewer $brewer)
    {
        $metadata = $this->entityManager->getClassMetadata(get_class($brewer));
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
        $this->entityManager->persist($brewer);
        $this->entityManager->flush();
    }
}
