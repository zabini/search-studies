<?php

namespace Tests\Unit\Domains\Core\Application;

use App\Domains\Core\Application\GetComposition;
use App\Domains\Core\Application\GetCompositionFinder;
use App\Domains\Core\Domain\CompositionRepository;
use App\Domains\Core\Infra\Persistence\ElasticCompositionRepository;
use Tests\TestCase;

class GetCompositionTest extends TestCase
{

    /** @test */
    public function shouldCreateCommand()
    {
        $command = new GetComposition(1);

        $this->assertEquals(1, $command->id);
    }

    /** @test */
    public function shouldFindAComposition()
    {

        $repository = $this->createMock(CompositionRepository::class);
        $repository->expects($this->once())
            ->method('getById')
            ->with(1)->willReturn([
                'description' => 'Isso da uma cadeia'
            ]);

        assert($repository instanceof CompositionRepository);

        $handler = new GetCompositionFinder($repository);

        $command = new GetComposition(1);
        $composition = $handler->handle($command);

        $expectedComposition = [
            'description' => 'Isso da uma cadeia'
        ];

        $this->assertEquals($expectedComposition, $composition);
    }
}
