<?php

namespace App\Event;

/**
 * Class LinkRegistrationEvents
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
final class LinkRegistrationEvents
{
    /**
     * This events occurs when a user register a new account
     *
     * @Event("App/Event/LinkRegistration/LinkRegistrationValidatorEvent")
     */
    const REGISTERED = 'link_registration.registered';
}