<?php

namespace App\Manager;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PostManager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class PostManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * PostManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PostRepository         $postRepository
     */
    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository)
    {
        $this->em = $entityManager;
        $this->postRepository = $postRepository;
    }

    /**
     * @return int|mixed|string
     */
    public function getThreeLastPost()
    {
        return $this->postRepository->findThreeLastPost();
    }
}