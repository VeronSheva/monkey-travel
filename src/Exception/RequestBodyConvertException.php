<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class RequestBodyConvertException extends \RuntimeException
{

    #[Pure]
    public function __construct(\Throwable $previous)
    {
        parent::__construct('error while unmarshalling request body', 0, $previous);
    }
}
