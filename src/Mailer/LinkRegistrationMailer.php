<?php

namespace App\Mailer;

use App\Entity\LinkRegistration;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class LinkRegistrationMailer
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationMailer extends AbstractMailer
{
    /**
     * @param LinkRegistration $linkRegistration
     * @param string           $validator
     * @param string           $email
     *
     * @throws TransportExceptionInterface
     */
    public function sendLinkForRegistration(LinkRegistration $linkRegistration, string $validator, string $email)
    {
        $message = $this->createTemplateMessage(
            'Link for create your account for sirius',
            'email/link_registration.html.twig',
            [
                'selector' => $linkRegistration->getSelector(),
                'validator' => $validator,
            ]
        )
            ->from('noreply@sirius.com')
            ->to($email)
        ;

        $this->sendMessage($message);
    }
}