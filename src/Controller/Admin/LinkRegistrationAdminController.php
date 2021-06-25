<?php

namespace App\Controller\Admin;

use App\Event\LinkRegistration\LinkRegistrationValidatorEvent;
use App\Event\LinkRegistrationEvents;
use App\Form\LinkRegistrationFormType;
use App\Manager\LinkRegistrationManager;
use App\Utils\Security\TokenManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LinkRegistrationAdminController
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class LinkRegistrationAdminController extends CRUDController
{
    /**
     * @var LinkRegistrationManager
     */
    private $linkRegistrationManager;

    /**
     * LinkRegistrationAdminController constructor.
     *
     * @param LinkRegistrationManager $linkRegistrationManager
     */
    public function __construct(LinkRegistrationManager $linkRegistrationManager)
    {
        $this->linkRegistrationManager = $linkRegistrationManager;
    }

    /**
     * @param Request                  $request
     * @param EventDispatcherInterface $dispatcher
     *
     * @return Response
     * @throws \Exception
     */
    public function newAction(Request $request, EventDispatcherInterface $dispatcher)
    {
        $linkRegistration = $this->linkRegistrationManager->createLinkRegistration();
        $form = $this->createForm(LinkRegistrationFormType::class, $linkRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = TokenManager::getToken();
            $linkRegistration->setTokenRegistration(TokenManager::hashToken($token));
            $validator = TokenManager::getValidator($token);
            $email = $form->get('email')->getData();

            $this->linkRegistrationManager->save($linkRegistration);

            $event = new LinkRegistrationValidatorEvent($linkRegistration, $validator, $email);
            $dispatcher->dispatch($event, LinkRegistrationEvents::REGISTERED);

            return $this->redirectToRoute('admin_app_linkregistration_list');
        }

        return $this->renderWithExtraParams('admin/CRUD/link_registration_new.html.twig', [
            'object' => $linkRegistration,
            'action' => 'link_registration',
            'form' => $form->createView(),
            'csrf_token' => $this->getCsrfToken('sonata.new'),
        ], null);
    }
}