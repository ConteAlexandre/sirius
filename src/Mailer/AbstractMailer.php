<?php

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * Class AbstractMailer
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
abstract class AbstractMailer
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $emailSubjectPrefix;

    /**
     * AbstractMailer constructor.
     *
     * @param MailerInterface $mailer
     * @param string          $emailSubjectPrefix
     */
    public function __construct(
        MailerInterface $mailer,
        string $emailSubjectPrefix
    )
    {
        $this->mailer = $mailer;
        $this->emailSubjectPrefix = $emailSubjectPrefix;
    }

    /**
     * @param array $address
     *
     * @return $this
     */
    public function setEmailAddress(array $address): AbstractMailer
    {
        $this->emailAddress = $address;

        return $this;
    }

    /**
     * @param string      $subject
     * @param string|null $htmlBody
     * @param string      $txtBody
     *
     * @return Email
     */
    protected function createMessage(string $subject, ?string $htmlBody, string $txtBody): Email
    {
        $message = (new Email())
            ->subject($subject)
            ->html($htmlBody)
            ->text($txtBody)
        ;

        return $message;
    }

    /**
     * @param string      $subject
     * @param string|null $htmlBody
     * @param array       $context
     *
     * @return TemplatedEmail
     */
    protected function createTemplateMessage(string $subject, ?string $htmlBody, array $context = []): TemplatedEmail
    {
        $message = (new TemplatedEmail())
            ->subject($subject)
            ->htmlTemplate($htmlBody)
            ->context($context);

        return $message;
    }

    /**
     * @param Email $message
     *
     * @throws TransportExceptionInterface
     */
    protected function sendMessage(Email $message): void
    {
        $this->mailer->send($message);
    }

    /**
     * @param string $key
     *
     * @return Address
     */
    public function getEmailAddress(string $key): Address
    {
        return Address::fromString($this->emailAddress[$key]);
    }
}