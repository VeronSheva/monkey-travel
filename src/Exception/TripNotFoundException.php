<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

class TripNotFoundException extends RuntimeException
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Trip not found');
    }
}
