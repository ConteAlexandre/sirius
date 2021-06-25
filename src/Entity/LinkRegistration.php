<?php

namespace App\Entity;

use App\Repository\LinkRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=LinkRegistrationRepository::class)
 */
class LinkRegistration
{
    use TimestampableEntity,
        BlameableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $selector;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tokenRegistration;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelector(): ?string
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     *
     * @return $this
     */
    public function setSelector(string $selector): self
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTokenRegistration(): ?string
    {
        return $this->tokenRegistration;
    }

    /**
     * @param string $tokenRegistration
     *
     * @return $this
     */
    public function setTokenRegistration(string $tokenRegistration): self
    {
        $this->tokenRegistration = $tokenRegistration;

        return $this;
    }
}
