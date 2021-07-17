<?php

declare(strict_types=1);

namespace App\Domains\Core\Infra\Persistence;

use App\Domains\Core\Domain\CompositionRepository;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticCompositionRepository implements CompositionRepository
{

    public function __construct(private Client $client)
    {
    }

    /**
     * @inheritDoc
     */
    public function getById(string $id): ?array
    {

        $params = [
            'index' => 'composition',
            'id' => $id
        ];

        try {
            return $this->client->get($params)['_source'];
        } catch (Missing404Exception $ex) {
            return null;
        }
    }
}
