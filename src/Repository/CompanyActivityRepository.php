<?php

namespace App\Repository;

use App\Entity\CompanyActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyActivity[]    findAll()
 * @method CompanyActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyActivity::class);
    }
}
