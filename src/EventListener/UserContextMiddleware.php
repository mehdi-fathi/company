<?php

namespace App\EventListener;

use App\Service\UserContext;
use App\Service\UserContextInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *
 */
class UserContextMiddleware
{
    /**
     * @var \App\Service\UserContextInterface
     */
    private $userContext;

    /**
     * @param \App\Service\UserContextInterface $userContext
     */
    public function __construct(UserContextInterface $userContext)
    {
        $this->userContext = $userContext;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event)
    {

        $request = $event->getRequest();

        $currentUserId = $request->headers->get('CurrentUser');

        if (!empty($currentUserId)) {
            $this->userContext->setCurrentUser($currentUserId);
        }

        if (!$this->userContext->getCurrentUser()) {

            $response = new JsonResponse([
                'message' => 'You must pass CurrentUser header to detect your user.',
                'code' => $currentUserId,
            ]);
            $event->setResponse($response);
        }
    }
}
