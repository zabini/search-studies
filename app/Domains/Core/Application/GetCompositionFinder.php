<?php

declare(strict_types=1);

namespace App\Domains\Core\Application;

use App\Domains\Core\Domain\CompositionRepository;

class GetCompositionFinder
{

    /**
     * @param CompositionRepository $repository
     */
    public function __construct(private CompositionRepository $repository)
    {
    }

    /**
     * @param GetComposition $command
     * @return array|null
     */
    public function handle(GetComposition $command): ?array
    {
        return $this->repository->getById($command->id);
    }
}
