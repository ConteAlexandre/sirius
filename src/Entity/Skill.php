<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    use TimestampableEntity,
        BlameableEntity;

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
     * @Assert\NotBlank(message="Le nom ne peut être nul")
     * @Assert\Length(
     *     min="5",
     *     minMessage="Le nom de l'activité doit faire minimum 5 caractères",
     *     max="50",
     *     maxMessage="Le nom de l'áctivité doit faire maximum 50 caractères",
     * )
     *
     * @ORM\Column(type="string", length=100, name="name")
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="skills")
     */
    private $users;

    /**
     * Skill constructor.
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
            $user->addSkill($this);
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
            $user->removeSkill($this);
        }

        return $this;
    }
}
