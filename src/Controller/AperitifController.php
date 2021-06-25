<?php

namespace App\Controller;

use App\Entity\Aperitif;
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
    public function setAperitif(Request $request, AperitifRepository $aperitifRepository): Response
    {
        $response = new Response();
        $aperitif = new Aperitif();
        $reqData = json_decode($request->getContent(), true);
        $aperitif->setDate($reqData["date"])
            ->setComment($reqData["comment"]);


        $em = $this->getDoctrine()->getManager();
        $em->persist($aperitif);
        $em->flush();
        $response->setContent($aperitif->getId());
        $response->setStatusCode(Response::HTTP_CREATED);
        return $response;
    }


}
