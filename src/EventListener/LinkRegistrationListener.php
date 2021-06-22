<?php

namespace App\EventListener;

use App\Event\LinkRegistration\LinkRegistrationValidatorEvent;
use App\Event\LinkRegistrationEvents;
use App\Mailer\LinkRegistrationMailer;
use App\Manager\LinkRegistrationManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class LinkRegistrationListener
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LinkRegistrationManager
     */
    private $linkRegistrationManager;

    /**
     * @var LinkRegistrationMailer
     */
    private $linkRegistrationMailer;

    public function __construct(
        EntityManagerInterface $entityManager,
        LinkRegistrationManager $linkRegistrationManager,
        LinkRegistrationMailer $linkRegistrationMailer
    )
    {
        $this->em = $entityManager;
        $this->linkRegistrationManager = $linkRegistrationManager;
        $this->linkRegistrationManager = $linkRegistrationMailer;
    }

    /**
     * (@inheritdoc)
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LinkRegistrationEvents::REGISTERED => 'onLinkRegistrationRegister'
        ];
    }

    /**
     * @param LinkRegistrationValidatorEvent $event
     *
     * @throws TransportExceptionInterface
     */
    public function onLinkRegistrationRegister(LinkRegistrationValidatorEvent $event)
    {
        $linkRegistration = $event->getLinkRegistration();
        $validator = $event->getValidator();
        $email = $event->getEmail();

        $this->linkRegistrationMailer->sendLinkForRegistration($linkRegistration, $validator, $email);
    }
}