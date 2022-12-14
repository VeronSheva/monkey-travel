<?php

namespace App\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

class PurchaseNotFoundException extends RuntimeException
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Purchase not found');
    }
}
