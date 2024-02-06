<?php

namespace App\Exception;

use App\Exception\PublishedMessageException;
use App\Exception\UserInputException;

/**
 *
 */
class AccessDeniedException extends \Exception
{

    /**
     * @var string
     */
    protected $message = "Access denied.";
}
