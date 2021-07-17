<?php

declare(strict_types=1);

namespace App\Domains\Core\Application;

class GetComposition
{
    public function __construct(public string $id)
    {
    }
}
