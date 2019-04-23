<?php

namespace App\Repository;

use App\Entity\Keyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Keyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keyword[]    findAll()
 * @method Keyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Keyword::class);
    }

    /**
     * Find keyword by word
     *
     * @param string $keyword
     * @return Keyword
     */
    public function findOneOrCreate(string $keyword): Keyword
    {
        $entity = $this->findOneBy(['keyword' => $keyword]);

        if(!$entity)
        {
            $entity = new Keyword();
            $entity->setKeyword($keyword);
            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }
}
