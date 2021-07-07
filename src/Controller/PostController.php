<?php

namespace App\Controller;

use App\Manager\PostManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 *
 * @Route("/post", name="post_")
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class PostController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     *
     * @param PostManager $postManager
     *
     * @return JsonResponse
     */
    public function listThreeLastPost(PostManager $postManager): JsonResponse
    {
        $posts = $postManager->getThreeLastPost();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($posts, 'json', SerializationContext::create());

        return new JsonResponse($jsonContent, Response::HTTP_OK, [], 'json');
    }
}