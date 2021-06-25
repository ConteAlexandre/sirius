<?php

namespace App\Controller;

use App\Form\Security\RegisterFormType;
use App\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserController
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserController extends AbstractController
{
    /**
     * @Route("/register/{selector}/{validator}", name="register", methods={"POST", "GET"})
     * @ParamConverter("link_registration", options={"selector" = "selector"})
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     *
     * @param UserManager        $userManager
     * @param Request            $request
     * @param ValidatorInterface $validatorInterface
     *
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function registerAction(UserManager $userManager, Request $request, ValidatorInterface $validatorInterface)
    {
        $data = json_decode($request->getContent(), true);
        $user = $userManager->createUser();
        $form = $this->createForm(RegisterFormType::class, $user);
        if ($form->isSubmitted()) {
            $form->submit($data);

            $violation = $validatorInterface->validate($user);

            if (count($violation) > 0) {
                foreach ($violation as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }

            $userManager->save($user);

            return new JsonResponse('User created');
        } else {
            return $this->render('register.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}