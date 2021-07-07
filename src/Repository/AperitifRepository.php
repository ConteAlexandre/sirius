<?php

namespace App\Repository;

use App\Entity\Aperitif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
     * @throws NonUniqueResultException
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
}
