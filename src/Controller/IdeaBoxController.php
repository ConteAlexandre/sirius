<?php

namespace App\Controller;

use App\Form\IdeaBoxFormType;
use App\Manager\IdeaBoxManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class IdeaBoxController
 *
 * @Route("/api/ideabox", name="idea_box")
 */
class IdeaBoxController extends AbstractController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     * @param IdeaBoxManager     $ideaManager
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function postIdea(Request $request, IdeaBoxManager $ideaManager, ValidatorInterface  $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        $ideabox = $ideaManager->createIdeaBox();
        $form = $this->createForm(IdeaBoxFormType::class, $ideabox);
        $form->submit($data);


        $violation = $validator->validate($ideabox);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $ideaManager->save($ideabox);

        return new JsonResponse('Idea Box created');
    }
}
