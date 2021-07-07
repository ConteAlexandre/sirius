<?php

namespace App\Repository;

use App\Entity\Aperitif;
use App\Entity\OfficialChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfficialChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfficialChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfficialChat[]    findAll()
 * @method OfficialChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfficialChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfficialChat::class);
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
    //  * @return OfficialChat[] Returns an array of OfficialChat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfficialChat
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
