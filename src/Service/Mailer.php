<?php

namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use App\Entity\user;

class Mailer
{

    private $twig;

    private $mailer;

    /**
     * [__construct]
     * @param Environment  $twig
     * @param Swift_Mailer $mailer
     */
    public function __construct(
        Environment $twig,
        Swift_Mailer $mailer
    ) {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * [sendMail]
     * @param  User   $user
     * @param  String $title
     * @param  String $view
     */
    public function sendMail(User $user, String $title, String $view)
    {
        $message = (new Swift_Message($title))
            ->setFrom('contact@bastienvacherand.fr')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render($view, ['user' => $user]),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
