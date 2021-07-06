<?php


namespace App\Manager;

use App\Entity\UnofficialChat;
use App\Repository\UnofficialChatRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UnofficialChatManager
 * @package App\Manager
 */
class UnofficialChatManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var UnofficialChatRepository
     */
    protected $unofficialChatRepository;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param UnofficialChatRepository $unofficialChatRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UnofficialChatRepository $unofficialChatRepository)
    {
        $this->em = $entityManager;
        $this->unofficialChatRepository = $unofficialChatRepository;
    }

    /**
     * @return UnofficialChat
     */
    public function createUnOfficialChat(): UnofficialChat
    {
        $officialChat = new UnofficialChat();
        $officialChat->setEnabled(true);
        return $officialChat;
    }

    /**
     * @return array
     */
    public function findLastMessages():array
    {
        return $this->unofficialChatRepository->findLastMessages();
    }

    /**
     * @param $date
     * @return array
     */
    public function findMessageSince($date):array
    {
        $tst = $this->unofficialChatRepository->findMessageSince($date);
        return $tst;
    }

    /**
     * @param UnofficialChat $unofficialChat
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(UnofficialChat $unofficialChat, bool $andFlush = true)
    {
        $this->em->persist($unofficialChat);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}