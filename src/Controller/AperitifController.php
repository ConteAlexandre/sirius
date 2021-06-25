<?php

namespace App\Controller;

use App\Entity\Aperitif;
use App\Form\AperitifFormType;
use App\Manager\AperitifManager;
use App\Repository\AperitifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AperitifController extends AbstractController
{

    private function serializeAperitif($aperitif)
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getSlug();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        return $serializer->serialize($aperitif, 'json');
    }


    /**
     * @Route("/aperitif", name="aperitif", methods={"GET"})
     */
    public function getAperitif(Request $request, AperitifRepository $aperitifRepository): Response
    {
        $filter = [];
        $em = $this->getDoctrine()->getManager();
        $champs = $em->getClassMetadata(Aperitif::class)->getFieldNames();
        foreach ($champs as $champ) {
            if ($request->query->get($champ)) {
                $filter[$champ] = $request->query->get($champ);
            }
        }
        return JsonResponse::fromJsonString($this->serializeAperitif($aperitifRepository->findBy($filter)));
    }

    /**
     * @Route("/aperitif", name="aperitif", methods={"POST"})
     */
    public function postAperitif(Request $request, AperitifManager $aperitifManager, ValidatorInterface  $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        $aperitif = $aperitifManager->createAperitif();
        $form = $this->createForm(AperitifFormType::class, $aperitif);
        $form->submit($data);


        $violation = $validator->validate($aperitif);

        if (count($violation) > 0) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $aperitifManager->save($aperitif);

        return new JsonResponse('Aperitif created');
    }


}
