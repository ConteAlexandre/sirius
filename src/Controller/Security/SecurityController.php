<?php

namespace App\Controller\Security;

use App\Form\Security\RegisterFormType;
use App\Manager\LinkRegistrationManager;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SecurityController
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/register/{selector}/{validator}", name="register", methods={"POST", "GET"})
     * @ParamConverter("link_registration", options={"selector" = "selector"})
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     *
     * @param UserManager             $userManager
     * @param Request                 $request
     * @param ValidatorInterface      $validatorInterface
     * @param LinkRegistrationManager $linkRegistrationManager
     *
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function registerAction(UserManager $userManager, Request $request, ValidatorInterface $validatorInterface, LinkRegistrationManager $linkRegistrationManager)
    {
        $data = json_decode($request->getContent(), true);
        $user = $userManager->createUser();
        $linkRegistration = $linkRegistrationManager->getLinkRegistration($request->attributes->get('selector'));
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->submit($data);

        $violation = $validatorInterface->validate($user);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $linkRegistration->eraseCredentials();
        $linkRegistrationManager->save($linkRegistration);
        $userManager->save($user);

        return new JsonResponse('User created');
    }
}