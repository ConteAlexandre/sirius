<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Security\TokenManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserManager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encodePassword;

    /**
     * UserManager constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserRepository               $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->em = $entityManager;
        $this->userRepository = $userRepository;
        $this->encodePassword = $userPasswordEncoder;
    }

    /**
     * @return User
     * @throws \Exception
     */
    public function createUser(): User
    {
        $user = new User();
        $user
            ->setEnabled(false)
            ->setSelector(TokenManager::getSelector(16));

        return $user;
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     */
    public function updatePassword(User $user)
    {
        if (0 !== strlen($user->getPlainPassword())) {
            $user->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));
            $user->setPassword($this->encodePassword->encodePassword($user, $user->getPlainPassword()));
            $user->eraseCredentials();
        }
    }

    /**
     * @param User $user
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(User $user, bool $andFlush = true)
    {
        $this->updatePassword($user);
        $this->em->persist($user);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}