<?php

namespace App\Manager;

use App\Entity\Aperitif;
use App\Repository\AperitifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class AperitifManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var AperitifRepository
     */
    protected $aperitifRepository;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param AperitifRepository $aperitifRepository
     */
    public function __construct(EntityManagerInterface $entityManager, AperitifRepository $aperitifRepository)
    {
        $this->em = $entityManager;
        $this->aperitifRepository = $aperitifRepository;
    }

    /**
     * @return Aperitif
     */
    public function createAperitif(): Aperitif
    {
        $aperitif = new Aperitif();
        $aperitif->setEnabled(true);
        return $aperitif;
    }

    /**
     * @param Aperitif           $aperitif
     * @param AperitifRepository $aperitifRepository
     *
     * @return bool
     * @throws NonUniqueResultException
     */
    public function checkAuthorizeAperitif(Aperitif $aperitif, AperitifRepository $aperitifRepository): bool
    {
        $user = $aperitif->getCreatedBy();
        $lastaperitif = $aperitifRepository->selectLastAperitifByUser($user);
        if ($lastaperitif != null) {
            $datelast2 = $lastaperitif->getCreatedAt();

            $date2 = new \DateTime('now');

            $interval = date_diff($datelast2, $date2)->format('%R%');

            if ($interval >= 1) {
                 return true;
             } else {
                return false;
            }
        }else {
            return true;
        }
    }

    /**
     * @param Aperitif $aperitif
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(Aperitif $aperitif, bool $andFlush = true)
    {
        $this->em->persist($aperitif);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
