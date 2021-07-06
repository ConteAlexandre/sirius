<?php

namespace App\Controller;

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

    public function updateAction(UserManager $userManager, Request $request, ValidatorInterface $validator)
    {
        $user = $this->getUser();

    }
}