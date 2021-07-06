<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class EnabledEntityTrait
 */
trait EnabledEntityTrait
{
    /**
     * @var bool
     *
     * @Serializer\Exclude()
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnabled(): string
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return true === $this->enabled;
    }
}