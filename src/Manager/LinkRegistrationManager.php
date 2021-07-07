<?php

namespace App\Manager;

use App\Entity\LinkRegistration;
use App\Repository\LinkRegistrationRepository;
use App\Utils\Security\TokenManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LinkRegistrationManager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LinkRegistrationRepository
     */
    private $linkRegistrationRepository;

    /**
     * LinkRegistrationManager constructor.
     *
     * @param EntityManagerInterface     $entityManager
     * @param LinkRegistrationRepository $linkRegistrationRepository
     */
    public function __construct(EntityManagerInterface $entityManager, LinkRegistrationRepository $linkRegistrationRepository)
    {
        $this->em = $entityManager;
        $this->linkRegistrationRepository = $linkRegistrationRepository;
    }

    /**
     * @return LinkRegistration
     * @throws \Exception
     */
    public function createLinkRegistration(): LinkRegistration
    {
        $linkRegistration = new LinkRegistration();
        $linkRegistration->setSelector(TokenManager::getSelector(16));

        return $linkRegistration;
    }

    /**
     * @param string $selector
     *
     * @return LinkRegistration|null
     */
    public function getLinkRegistration(string $selector): LinkRegistration
    {
        return $this->linkRegistrationRepository->findOneBy(['selector' => $selector]);
    }

    /**
     * @param LinkRegistration $linkRegistration
     * @param bool             $andFlush
     */
    public function save(LinkRegistration $linkRegistration, bool $andFlush = true)
    {
        $this->em->persist($linkRegistration);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}