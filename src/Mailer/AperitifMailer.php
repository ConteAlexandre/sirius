<?php


namespace App\Mailer;


use App\Entity\Aperitif;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class AperitifMailer extends AbstractMailer
{
    /**
     * @param Aperitif         $aperitif
     * @param string           $email
     *
     * @throws TransportExceptionInterface
     */

    public function sendAperitifMail(Aperitif $aperitif, string $email){

        $message = $this->createTemplateMessage(
            'Nouvel aperitif prévu',
            'email/aperitif.html.twig',
            [
                'date' => $aperitif->getDate(),
                'comment' => $aperitif->getComment()
            ]
        )
            ->from('noreply@sirius.com')
            ->to($email)
        ;

        $this->sendMessage($message);

    }

}
