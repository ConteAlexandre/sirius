<?php

namespace App\Repository;

use App\Entity\Aperitif;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Aperitif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aperitif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aperitif[]    findAll()
 * @method Aperitif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AperitifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aperitif::class);
    }

    /**
     * @param $user
     * @return Aperitif|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function selectLastAperitifByUser($user): ?Aperitif
    {
        return $this->createQueryBuilder('a')
            ->select("a")
            ->where("a.createdBy = :user")
            ->setParameter('user', $user)
            ->orderBy("a.createdAt", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;

    }

    // /**
    //  * @return Aperitif[] Returns an array of Aperitif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aperitif
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
