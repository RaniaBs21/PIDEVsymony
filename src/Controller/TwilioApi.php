<?php

namespace App\Controller;

use App\Repository\PointsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class TwilioApi extends AbstractController
{
    private $pointsRepository;

    public function __construct(PointsRepository $pointsRepository)
    {
        $this->pointsRepository = $pointsRepository;
    }

    /**
     * @Route("/send-sms", name="send_sms")
     * @throws ConfigurationException|TwilioException
     */
    public function sendSms(): Response
    {

        $sid = getenv("TWILIO_ACCOUNT_SID2");
        $token = getenv("TWILIO_AUTH_TOKEN2");
        $client = new Client($sid, $token);
        $score = $this->pointsRepository->find(1)->getScore(); // Supposons que le score est stocké dans une entité Score avec l'id 1


        $message = $client->messages->create("+21621845071", [
            "body" => "Le score actuel est de " . $score . " points. Cette information vous est fournie par notre application Symfony.",
            "from" => "+16813346942",
            "mediaUrl" => ["https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg"]
        ]);

        return $this->render('twilio_api/send_sms.html.twig', [
            'message' => $message]);
    }
}




