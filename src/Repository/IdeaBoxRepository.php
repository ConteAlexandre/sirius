<?php

namespace App\Repository;

use App\Entity\IdeaBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IdeaBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdeaBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdeaBox[]    findAll()
 * @method IdeaBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdeaBox::class);
    }
}
