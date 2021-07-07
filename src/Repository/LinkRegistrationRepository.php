<?php

namespace App\Repository;

use App\Entity\LinkRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinkRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkRegistration[]    findAll()
 * @method LinkRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkRegistration::class);
    }
}
