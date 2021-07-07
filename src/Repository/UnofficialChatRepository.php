<?php

namespace App\Repository;

use App\Entity\UnofficialChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UnofficialChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnofficialChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnofficialChat[]    findAll()
 * @method UnofficialChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnofficialChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnofficialChat::class);
    }
    public function findLastMessages()
    {
        return $this->createQueryBuilder('a')
            ->select("a")
            ->orderBy("a.createdAt", "DESC")
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;

    }
    public function findMessageSince($date)
    {
        return $this->createQueryBuilder('a')
            ->select("a")
            ->where('a.createdAt >= :val')
            ->setParameter('val',$date)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return UnofficialChat[] Returns an array of UnofficialChat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UnofficialChat
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
