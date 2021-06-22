<?php

namespace App\Controller\Admin;

use App\Form\LinkRegistrationFormType;
use App\Manager\LinkRegistrationManager;
use App\Utils\Security\TokenManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminUserController
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class AdminUserController extends CRUDController
{
    /**
     * @var LinkRegistrationManager
     */
    private $linkRegistrationManager;

    /**
     * AdminUserController constructor.
     *
     * @param LinkRegistrationManager $linkRegistrationManager
     */
    public function __construct(LinkRegistrationManager $linkRegistrationManager)
    {
        $this->linkRegistrationManager = $linkRegistrationManager;
    }

    public function createLinkForInscription(Request $request)
    {
        $linkRegistration = $this->linkRegistrationManager->createLinkRegistration();
        $form = $this->createForm(LinkRegistrationFormType::class, $linkRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = TokenManager::getToken();
            $linkRegistration->setTokenRegistration($token);
            $validator = TokenManager::getValidator($token);

            $this->linkRegistrationManager->save($linkRegistration);

            
        }
    }
}