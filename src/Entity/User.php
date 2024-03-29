<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Entity\Traits\RolableEntityTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    use TimestampableEntity,
        BlameableEntity,
        EnabledEntityTrait,
        RolableEntityTrait;

    const ROLE_DEFAULT = 'ROLE_USER';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le champs username ne doit pas être nul")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le pseudo doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="Le pseudo ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100, name="username")
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le prénom ne doit pas être nul")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le prénom doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="Le prénom ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100, name="first_name")
     */
    private $firstName;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le nom de famille ne doit pas être nul")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le nom de famille doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="Le nom de famille ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100, name="last_name")
     */
    private $lastName;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le nom de la company ne doit pas être nul")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le nom de la company doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="Le nom de la company ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100, name="company")
     */
    private $company;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le nom de la company ne doit pas être nul")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le nom de la company doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="Le nom de la company ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100, name="company_activity")
     */
    private $companyActivity;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="L'email ne doit pas être nul")
     * @Assert\Email(message="L'email n'est pas valide")
     * @Assert\Length(
     *     min="8",
     *     minMessage="L'email doit faire minimum 8 caractères",
     *     max="100",
     *     maxMessage="L'emil ne doit pas contenir plus de 100 caractères"
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le champs boisson ne peut être nul")
     * @Assert\Length(
     *     min="3",
     *     minMessage="Le champs boisson doit faire au moins 3 caractères",
     *     max="80",
     *     maxMessage="Le champs boisson doit contenir 80 caractères maximum",
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=80, name="beverage")
     */
    private $beverage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le champs mot de passe ne doit pas être nul")
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="reset_token")
     */
    private $resetToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="confirmation_token")
     */
    private $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="request_password_at")
     */
    private $requestPasswordAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, nullable=true, name="selector")
     */
    private $selector;

    /**
     * @Serializer\Groups(groups="users")
     * @Serializer\SkipWhenEmpty()
     *
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="users")
     */
    private $skills;

    /**
     * @return string
     */
    public static function getDefaultRole()
    {
        return self::ROLE_DEFAULT;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

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
    public function getUsername(): ?string
    {
        return $this->username;
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
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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
     * @return string
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string $company
     *
     * @return User
     */
    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return CompanyActivity|null
     */
    public function getCompanyActivity(): ?CompanyActivity
    {
        return $this->companyActivity;
    }

    /**
     * @param CompanyActivity|null $companyActivity
     *
     * @return $this
     */
    public function setCompanyActivity(?CompanyActivity $companyActivity): self
    {
        $this->companyActivity = $companyActivity;

        return $this;
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
     * @return string
     */
    public function getBeverage(): ?string
    {
        return $this->beverage;
    }

    /**
     * @param string $beverage
     *
     * @return User
     */
    public function setBeverage(string $beverage): self
    {
        $this->beverage = $beverage;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     *
     * @return User
     */
    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    /**
     * @param string $confirmationToken
     *
     * @return User
     */
    public function setConfirmationToken(string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRequestPasswordAt(): ?\DateTime
    {
        return $this->requestPasswordAt;
    }

    /**
     * @param \DateTime $requestPasswordAt
     *
     * @return User
     */
    public function setRequestPasswordAt(\DateTime $requestPasswordAt): self
    {
        $this->requestPasswordAt = $requestPasswordAt;

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
     * @return string
     */
    public function getSelector(): ?string
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     *
     * @return User
     */
    public function setSelector(string $selector): self
    {
        $this->selector = $selector;

        return $this;
    }

    /**
     * Erase credentials
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function removeSkill(Skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }
}
