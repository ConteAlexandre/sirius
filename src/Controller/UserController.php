<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Manager\UserManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserController
 *
 * @Route("/api/user", name="user_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class UserController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @param UserManager $userManager
     *
     * @return JsonResponse
     */
    public function listAction(UserManager $userManager): JsonResponse
    {
        $users = $userManager->getAllUserEnabled();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($users, 'json', SerializationContext::create()->setGroups('users'));

        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/update", name="update", methods={"PUT"})
     *
     * @param UserManager        $userManager
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateAction(UserManager $userManager, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $user = $this->getUser();
        $data = json_encode($request->getContent(), true);
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->submit($data);

        $violation = $validator->validate($user);
        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $userManager->save($user);

        return new JsonResponse('Profile is updated');
    }
}