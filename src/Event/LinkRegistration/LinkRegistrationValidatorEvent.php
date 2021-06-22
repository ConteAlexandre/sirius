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
     * LinkRegistrationValidatorEvent constructor.
     *
     * @param LinkRegistration   $linkRegistration
     * @param string $validator
     */
    public function __construct(LinkRegistration $linkRegistration, string $validator)
    {
        parent::__construct($linkRegistration);

        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getValidator(): string
    {
        return $this->validator;
    }
}