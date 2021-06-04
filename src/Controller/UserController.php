<?php

namespace App\Controller;

use App\Form\Security\RegisterFormType;
use App\Manager\UserManager;
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
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param UserManager        $userManager
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function registerAction(UserManager $userManager, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $userManager->createUser();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->submit($data);

        $violation = $validator->validate($user);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $userManager->save($user);

        return new JsonResponse('User created');
    }
}