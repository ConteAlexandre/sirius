<?php

namespace App\Controller;

use App\Entity\IdeaBox;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaBoxController extends AbstractController
{
    /**
     * @Route("/ideabox/", name="idea_box", methods={"POST"})
     */
    public function postIdea(Request $request): Response
    {
        $response = new Response();
        $idea = new IdeaBox();
        $reqData = json_decode($request->getContent(), true);
        $idea->setContent($reqData["content"]);


        $em = $this->getDoctrine()->getManager();
        $em->persist($idea);
        $em->flush();
        $response->setContent($idea->getId());
        $response->setStatusCode(Response::HTTP_CREATED);
        return $response;
    }
}
