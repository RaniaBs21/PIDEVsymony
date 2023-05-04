<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Twilio\Rest\Client;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;


class TwilioSmsController extends AbstractController
{
    private $evenementRepository;
    
    public function __construct(EvenementRepository $evenementRepository)
    {
        $this->evenementRepository = $evenementRepository;
    }

    /**
     * @Route("/twilio/sms", name="app_twilio_sms")
     * @throws ConfigurationException|TwilioException
     */
    public function sendSms(): Response
    {

            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");

            $client = new Client($sid, $token);
            $evenement = $this->evenementRepository->findSEventByid(4); // Récupère l'événement en question à partir de la base de données

            $message = $client->messages->create("+21692970155", [
                "body" => "Vous venez de vous inscrire à l'événement " . $evenement->getTitreEV() . ". L'événement aura lieu le " . $evenement->getDateEv()->format('d-m-Y') . ". Nous vous remercions pour votre participation!",
                //"body" => "Vous venez de vous inscrire à l'événement  L'événement aura lieu le . Nous vous remercions pour votre participation!",
                "from" => "+16205249771",
                "mediaUrl" => ["https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg"]
            
            ]);
            

        return $this->render('twilio_sms/index.html.twig', [
            'message' => $message,
        ]);
    }
}