<?php

namespace App\Manager;

use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminUserManager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdminUserManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var AdminUserRepository
     */
    protected $adminUserRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $encoderPassword;

    /**
     * AdminUserManager constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param AdminUserRepository          $adminUserRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, AdminUserRepository $adminUserRepository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->em = $entityManager;
        $this->adminUserRepository = $adminUserRepository;
        $this->encoderPassword = $userPasswordEncoder;
    }

    /**
     * @return AdminUser
     */
    public function createAdmin(): AdminUser
    {
        return new AdminUser();
    }

    /**
     * @param AdminUser $adminUser
     *
     * @throws \Exception
     */
    public function updatePassword(AdminUser $adminUser)
    {
        if (0 != strlen($password = $adminUser->getPlainPassword())) {
            $adminUser->setSalt(rtrim(str_replace('*', '.', base64_encode(random_bytes(32))), '='));
            $adminUser->setPassword($this->encoderPassword->encodePassword($adminUser, $password));
            $adminUser->eraseCredentials();
        }
    }

    /**
     * @param AdminUser $adminUser
     * @param bool      $andFlush
     *
     * @throws \Exception
     */
    public function save(AdminUser $adminUser, bool $andFlush = true)
    {
        $this->updatePassword($adminUser);

        $this->em->persist($adminUser);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}