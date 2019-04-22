<?php

namespace App\Repository;

use App\Entity\KeywordReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method KeywordReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeywordReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeywordReport[]    findAll()
 * @method KeywordReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KeywordReport::class);
    }

    // /**
    //  * @return KeywordReport[] Returns an array of KeywordReport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeywordReport
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
