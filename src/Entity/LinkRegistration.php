<?php

namespace App\Entity;

use App\Repository\LinkRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LinkRegistrationRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà existant et ne peut pas être réutilisé")
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
     * @Assert\NotBlank(message="L'email ne peut être nul")
     * @Assert\Email(message="L'email n'est pas valide")
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="50",
     *     maxMessage="L'emil ne doit pas contenir plus de 50 caractères"
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selector;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    /**
     * Erase Credentials
     */
    public function eraseCredentials()
    {
        $this->selector = null;
        $this->tokenRegistration = null;
    }
}
