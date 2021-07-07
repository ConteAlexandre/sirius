<?php

namespace App\Event\LinkRegistration;

use App\Entity\LinkRegistration;

/**
 * Class LinkRegistrationValidatorEvent
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationValidatorEvent extends LinkRegistrationEvent
{
    /**
     * @var string
     */
    protected $validator;

    /**
     * @var string
     */
    protected $email;

    /**
     * LinkRegistrationValidatorEvent constructor.
     *
     * @param LinkRegistration $linkRegistration
     * @param string           $validator
     * @param string           $email
     */
    public function __construct(LinkRegistration $linkRegistration, string $validator, string $email)
    {
        parent::__construct($linkRegistration);

        $this->validator = $validator;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getValidator(): string
    {
        return $this->validator;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}