<?php

namespace App\Controller\BackendController;


use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioApiController extends AbstractController
{
    private $courrepo;

    public function __construct(CoursRepository $courrepo)
    {
        $this->courrepo = $courrepo;
    }

    /**
     * @Route("/send-sms", name="send_sms")
     * @throws ConfigurationException|TwilioException
     */
    public function sendSms(): Response
    {

        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($sid, $token);


        $message = $client->messages->create("+21624250245", [
            "body" => "Cher client Un nouveau cours a ete ajouté dans ArtPlus.",
            "from" => "+16073262838",
            "mediaUrl" => ["https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg"]
        ]);

        return $this->render('twilio_api/send_sms.html.twig', [
            'message' => $message]);
    }
}




