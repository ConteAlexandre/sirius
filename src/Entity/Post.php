<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
     * @Assert\NotBlank(message="Le titre ne doit pas être vide")
     * @Assert\Length(
     *     min="8",
     *     minMessage="Le titre doit contenir au moins 8 caractères",
     *     max="50",
     *     maxMessage="Le titre doit contenir 50 caractères maximum",
     * )
     *
     * @ORM\Column(type="string", length=100, name="title")
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Le contenu ne doit pas être nul")
     * @Assert\Length(
     *     min="20",
     *     maxMessage="Le contenu doit faire au moins 20 caractères",
     * )
     *
     * @ORM\Column(type="text", name="content")
     */
    private $content;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
