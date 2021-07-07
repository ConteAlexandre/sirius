<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\CompanyActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompanyActivityRepository::class)
 * @UniqueEntity(fields={"name"}, message="Le nom {{ value }} est déjà utilisé")
 */
class CompanyActivity
{
    use TimestampableEntity,
        BlameableEntity,
        EnabledEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le champs name ne doit pas être nul")
     * @Assert\Length(
     *     min="5",
     *     minMessage="Le nom de l'activité doit faire minimum 5 caractères",
     *     max="50",
     *     maxMessage="Le nom de l'áctivité doit faire maximum 50 caractères",
     * )
     *
     * @Serializer\Groups(groups="users")
     *
     * @ORM\Column(type="string", length=150, name="name")
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="companyActivity")
     */
    private $users;

    /**
     * CompanyActivity constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompanyActivity($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompanyActivity() === $this) {
                $user->setCompanyActivity(null);
            }
        }

        return $this;
    }
}
