<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{   /*private $mailer;
    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $content, $subject)
    {   
        $email = (new Email())
            ->from('rahma.test.esprit@gmail.com')
            ->to($to)
            ->subject($subject)
            ->html($content);
        
        return $this->mailer->send($email);
        
    }*/  
    public function __construct(private MailerInterface $mailer) {}
    public function sendEmail(
        $to = 'rahmaaslimii83@gmail.com',
        $content = '<p>Vous êtes inscrit à l\'événement avec succès</p>',
        $subject = 'Participation à l\'événement!'
    ): void
    {   
        $email = (new Email())
            ->from('rahma.slimi@esprit.tn')
            ->to($to)
            ->subject($subject)
            ->html($content);
    
        $this->mailer->send($email);
    }
    
}