<?php

namespace Tests\Unit\Console\Commands;

use App\Errors\Repository\RepositoryNotOwnedError;
use App\Services\RepositoryService;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class CodeCommitTest extends TestCase {

    public function testNotOwnedRepo()
    {
        $this->instance(
            RepositoryService::class,
            Mockery::mock(RepositoryService::class, function(MockInterface $mock) {
                $mock
                    ->shouldReceive('getParentRepositories')
                    ->once()
                    ->andThrow(new RepositoryNotOwnedError());
            })
        );

        $this->artisan('code:commit testlib 3 dev')->expectsOutputToContain('not owned by the company');
    }
}
