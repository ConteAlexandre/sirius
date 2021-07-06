<?php


namespace App\Manager;


use App\Entity\OfficialChat;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OfficialChatRepository;

/**
 * Class OfficialChatManager
 * @package App\Manager
 */
class OfficialChatManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var OfficialChatRepository
     */
    protected $officialChatRepository;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param OfficialChatRepository $officialChatRepository
     */
    public function __construct(EntityManagerInterface $entityManager, OfficialChatRepository $officialChatRepository)
    {
        $this->em = $entityManager;
        $this->officialChatRepository = $officialChatRepository;
    }

    /**
     * @return OfficialChat
     */
    public function createOfficialChat(): OfficialChat
    {
        $officialChat = new OfficialChat();
        $officialChat->setEnabled(true);
        return $officialChat;
    }

    public function findLastMessages():array
    {
        return $this->officialChatRepository->findLastMessages();
    }

    public function findMessageSince($date):array
    {
        $tst = $this->officialChatRepository->findMessageSince($date);
        var_dump($tst);
        return $tst;
    }
    /**
     * @param OfficialChat $officialChat
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(OfficialChat $officialChat, bool $andFlush = true)
    {
        $this->em->persist($officialChat);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}