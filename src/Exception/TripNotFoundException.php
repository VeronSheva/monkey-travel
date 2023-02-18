<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class TripNotFoundException extends \RuntimeException
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Trip not found');
    }
}
