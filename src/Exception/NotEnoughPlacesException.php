<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;

class NotEnoughPlacesException extends \RuntimeException
{

    #[Pure]
    public function __construct()
    {
        parent::__construct('Not enough places for this trip');
    }
}
