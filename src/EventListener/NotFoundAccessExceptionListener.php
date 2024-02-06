<?php
// src/EventListener/NotFoundAccessExceptionListener.php

namespace App\EventListener;

use App\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 *
 */
class NotFoundAccessExceptionListener
{
    /**
     * @param \Symfony\Component\HttpKernel\Event\ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedException) {
            $response = new JsonResponse(['error' => $exception->getMessage()], JsonResponse::HTTP_NOT_FOUND);
            $event->setResponse($response);
        }
    }
}
