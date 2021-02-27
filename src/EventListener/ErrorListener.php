<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorListener
{
    //src/EventListener/ErrorListener.php
    public function onKernelException(ExceptionEvent $event)
    {
        // Get the exception object
        $exception = $event->getThrowable();

        $newExceptionText = \sprintf(
            'An error has occurred: %s [status code %s]',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Create new Response object
        $response = new Response();
        $response->setContent($newExceptionText);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}