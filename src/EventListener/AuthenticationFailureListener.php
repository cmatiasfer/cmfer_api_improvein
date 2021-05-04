<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener {
    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = [
            'status'  => '401 Unauthorized',
            'message' => 'Bad credentials, please verify that your username/password are correctly set',
        ];

        /* $response = new JWTAuthenticationFailureResponse($data); */
        $response = new JWTAuthenticationFailureResponse('Bad credentials, please verify that your username/password are correctly set',401);

        $event->setResponse($response);
    }
}