<?php

namespace App\Event\LinkRegistration;

use App\Entity\LinkRegistration;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class LinkRegistrationEvent
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationEvent extends Event
{
    /**
     * @var LinkRegistration
     */
    private $linkRegistration;

    /**
     * LinkRegistrationEvent constructor.
     *
     * @param LinkRegistration $linkRegistration
     */
    public function __construct(LinkRegistration $linkRegistration)
    {
        $this->linkRegistration = $linkRegistration;
    }

    /**
     * @return LinkRegistration
     */
    public function getLinkRegistration(): LinkRegistration
    {
        return $this->linkRegistration;
    }
}