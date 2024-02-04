<?php

namespace App\EventListener;

use App\Service\UserContext;
use App\Service\UserContextInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $currentUserId = $request->get('current_user_id');

        if (!empty($currentUserId)) {
            $this->userContext->setCurrentUser($currentUserId);
        }

        if (!$this->userContext->getCurrentUser()) {

            // $response = new JsonResponse([
            //     'message' => 'You must pass current_user_id to detect your user.',
            //     'code' => $currentUserId,
            // ]);
            // $event->setResponse($response);
        }

        // Your middleware logic goes here
    }
}
