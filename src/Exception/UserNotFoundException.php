<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class UserNotFoundException extends \RuntimeException
{

    #[Pure]
    public function __construct()
    {
        parent::__construct('User not found');
    }
}
