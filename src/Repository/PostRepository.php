<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Find Three Last Post
     */
    public function findThreeLastPost()
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->select('p.title', 'p.content')
            ->where('p.enabled = :enabled')
            ->orderBy('p.updatedAt', 'DESC')
            ->setMaxResults(3)
            ->setParameter('enabled', true)
        ;

        return $qb->getQuery()->getResult();
    }
}
