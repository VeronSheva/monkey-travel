<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class ValidationFailedException extends \RuntimeException
{
    #[Pure]
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
