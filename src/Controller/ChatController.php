<?php


namespace App\Controller;


use App\Form\OfficialChatFormType;
use App\Form\UnofficialChatFormType;
use App\Manager\OfficialChatManager;
use App\Manager\UnofficialChatManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ChatController
 * @Route("/api/chat")
 */
class ChatController extends AbstractController
{
    /**
     * @Route ("/official/send", name="send", methods={"POST"})
     * @param Request $request
     * @param OfficialChatManager $officialChatManager
     * @param ValidatorInterface $validator
     */
    public function sendMessageOfficialChat(Request $request, OfficialChatManager $officialChatManager, ValidatorInterface  $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $officialChat = $officialChatManager->createOfficialChat();
        $form = $this->createForm(OfficialChatFormType::class, $officialChat);
        $form->submit($data);

        $violation = $validator->validate($officialChat);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $officialChatManager->save($officialChat);

        return new JsonResponse('Message created');
    }

    /**
     * @Route("/official/lastmessage", name="lastmessage", methods={"GET"})
     * @param OfficialChatManager $officialChatManager
     */
    public function getLastMessageOfficialChat(OfficialChatManager $officialChatManager): JsonResponse
    {
        $messages = $officialChatManager->findLastMessages();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($messages, 'json', SerializationContext::create());
        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/official/lastmessage/since", name="since", methods={"POST"})
     * @param Request $request
     * @param OfficialChatManager $officialChatManager
     * @return JsonResponse
     */
    public function refreshMessageOfficialChat(Request $request, OfficialChatManager $officialChatManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $date = $data['date'];
        $messages = $officialChatManager->findMessageSince($date);

        return new JsonResponse($messages);
    }

    /**
     * @Route ("/unofficial/send", name="send", methods={"POST"})
     * @param Request $request
     * @param UnofficialChatManager $unofficialChatManager
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendMessageUnOfficialChat(Request $request, UnofficialChatManager $unofficialChatManager, ValidatorInterface  $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $unofficialChat = $unofficialChatManager->createUnOfficialChat();
        $form = $this->createForm(UnofficialChatFormType::class, $unofficialChat);
        $form->submit($data);

        $violation = $validator->validate($unofficialChat);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $unofficialChatManager->save($unofficialChat);

        return new JsonResponse('Message created');
    }

    /**
     * @Route("/unofficial/lastmessage", name="lastmessage", methods={"GET"})
     * @param UnofficialChatManager $unofficialChatManager
     * @return JsonResponse
     */
    public function getLastMessageUnOfficialChat(UnofficialChatManager $unofficialChatManager): JsonResponse
    {
        $messages = $unofficialChatManager->findLastMessages();
        $serialize = SerializerBuilder::create()->build();
        $jsonContent = $serialize->serialize($messages, 'json', SerializationContext::create());

        return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/unofficial/lastmessage/since", name="since", methods={"POST"})
     * @param Request $request
     * @param UnofficialChatManager $unofficialChatManager
     * @return JsonResponse
     */
    public function refreshMessageUnOfficialChat(Request $request, UnofficialChatManager  $unofficialChatManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $date = $data['date'];
        $messages = $unofficialChatManager->findMessageSince($date);

        return new JsonResponse($messages);
    }
}