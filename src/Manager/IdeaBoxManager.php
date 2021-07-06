<?php

namespace App\Manager;

use App\Entity\IdeaBox;
use App\Repository\IdeaBoxRepository;
use Doctrine\ORM\EntityManagerInterface;

class IdeaBoxManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var IdeaBoxRepository
     */
    protected $clientRepository;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param IdeaBoxRepository $ideaboxRepository
     */
    public function __construct(EntityManagerInterface $entityManager, IdeaBoxRepository $ideaboxRepository)
    {
        $this->em = $entityManager;
        $this->ideaboxRepository = $ideaboxRepository;
    }

    /**
     * @return IdeaBox
     */
    public function createIdeaBox(): IdeaBox
    {
        $ideabox = new IdeaBox();
        $ideabox->setEnabled(true);
        return $ideabox;
    }

    /**
     * @param IdeaBox $ideabox
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(IdeaBox $ideabox, bool $andFlush = true)
    {
        $this->em->persist($ideabox);
        if ($andFlush) {
            $this->em->flush();
        }
    }

}
