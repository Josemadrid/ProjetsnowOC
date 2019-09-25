<?php

namespace App\Repository;

use App\Entity\TokenPassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TokenPassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenPassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenPassword[]    findAll()
 * @method TokenPassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenPasswordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TokenPassword::class);
    }

    // /**
    //  * @return TokenPassword[] Returns an array of TokenPassword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TokenPassword
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
