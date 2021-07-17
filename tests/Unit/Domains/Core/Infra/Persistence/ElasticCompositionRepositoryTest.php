<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Core\Infra\Persistence;

use App\Domains\Core\Infra\Persistence\ElasticCompositionRepository;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Tests\TestCase;

class ElasticCompositionRepositoryTest extends TestCase
{

    /** @test */
    public function shouldFindCompositionById()
    {

        $client = $this->createMock(Client::class);
        $client->expects($this->once())
            ->method('get')
            ->with([
                'index' => 'composition',
                'id' => 2
            ])->willReturn([
                '_source' => [
                    'description' => 'Isso da uma cadeia'
                ]
            ]);

        assert($client instanceof Client);

        $repository = new ElasticCompositionRepository($client);

        $composition = $repository->getById("2");

        $expectedComposition = [
            'description' => 'Isso da uma cadeia'
        ];

        $this->assertEquals($expectedComposition, $composition);
    }

    /** @test */
    public function shouldReturnNullWhenNotFoundAComposition()
    {

        $client = $this->createMock(Client::class);
        $client->expects($this->once())
            ->method('get')
            ->with([
                'index' => 'composition',
                'id' => 3
            ])->will($this->throwException(
                new Missing404Exception()
            ));

        assert($client instanceof Client);

        $repository = new ElasticCompositionRepository($client);

        $composition = $repository->getById("3");

        $this->assertNull($composition);
    }
}
