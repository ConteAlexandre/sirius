<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdminUserRepository::class)
 * @UniqueEntity(fields={"email"}, message="This email is already used.")
 * @UniqueEntity(fields={"username"}, message="This username is already used.")
 */
class AdminUser implements UserInterface
{
    use TimestampableEntity,
        BlameableEntity,
        EnabledEntityTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="50",
     *     maxMessage="L'emil ne doit pas contenir plus de 50 caractères"
     * )
     *
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="50",
     *     maxMessage="L'emil ne doit pas contenir plus de 50 caractères"
     * )
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="50",
     *     maxMessage="L'emil ne doit pas contenir plus de 50 caractères"
     * )
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="50",
     *     maxMessage="L'emil ne doit pas contenir plus de 50 caractères"
     * )
     *
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @PasswordRequirements(
     *     minLength=8,
     *     requireNumbers=true,
     *     requireLetters=true,
     *     requireCaseDiff=true,
     *     requireSpecialCharacter=true,
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return array|string[]|null
     */
    public function getRoles(): ?array
    {
        if (empty($this->roles)){
            return ['ROLE_ADMIN'];
        }
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Erase credentials for value null
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
