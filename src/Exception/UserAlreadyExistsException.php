<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class UserAlreadyExistsException extends \RuntimeException
{

    #[Pure]
    public function __construct()
    {
        parent::__construct('This user already exists');
    }
}
