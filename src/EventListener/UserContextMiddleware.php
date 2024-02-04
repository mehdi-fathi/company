<?php

namespace App\EventListener;

use App\Service\UserContext;
use App\Service\UserContextInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class UserContextMiddleware
{
    private $userContext;

    public function __construct(UserContextInterface $userContext)
    {
        $this->userContext = $userContext;
    }

    public function onKernelRequest(RequestEvent $event)
    {

        $request = $event->getRequest();

        if($request->get('user_id')){
            $this->userContext->setCurrentUser($request->get('user_id'));
        }

        // Your middleware logic goes here
    }
}
