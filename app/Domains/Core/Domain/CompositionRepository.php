<?php

declare(strict_types=1);

namespace App\Domains\Core\Domain;

interface CompositionRepository
{

    /**
     * @param string $id
     * @return array
     */
    public function getById(string $id): ?array;
}
