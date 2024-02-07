<?php
// src/EventListener/NotFoundAccessExceptionListener.php

namespace App\EventListener;

use App\Exception\AccessDeniedException;
use App\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if ($exception instanceof AccessDeniedException || $exception instanceof NotFoundHttpException) {

            $res = ApiResponse::getResponse(false, null, null, $exception->getMessage());
            $response = new JsonResponse($res, $exception->getStatusCode());

            $event->setResponse($response);

        }
    }
}
