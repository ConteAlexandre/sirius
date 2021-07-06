<?php

namespace App\Controller;

use App\Form\AperitifFormType;
use App\Manager\AperitifManager;
use App\Manager\UserManager;
use App\Repository\AperitifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AperitifController
 *
 * @Route("/aperitif", name="aperitif_")
 */
class AperitifController extends AbstractController
{
    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function postAperitif(Request $request,UserManager $userManager, AperitifManager $aperitifManager, ValidatorInterface  $validator,  AperitifRepository $aperitifRepository): Response
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

        $emails = $userManager->findEmailUsers();

        if ($aperitifManager->checkAuthorizeAperitif($aperitif, $aperitifRepository)){
            foreach ($emails as $email){
                $aperitifManager->save($aperitif);
                /*$aperitifMailer->sendAperitifMail($aperitif, $email);*/
            }

            return new JsonResponse('Aperitif created');
        }else{
            return new JsonResponse('Vous avez déjà créé un apéritif aujourdh\'ui');
        }
    }
}
