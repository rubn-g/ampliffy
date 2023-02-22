<?php

namespace App\Console\Commands;

use App\Errors\Repository\RepositoryNotOwnedError;
use App\Services\RepositoryService;
use Illuminate\Console\Command;

class CodeCommit extends Command
{
    protected $signature = 'code:commit {repo} {commitId} {branch}';

    protected $description = 'Code commited to the CI/CD app';


    protected RepositoryService $repositoryService;

    /**
     * Execute the console command.
     */
    public function handle(RepositoryService $repositoryService): void
    {
        $repo = $this->argument('repo');

        try {
            $parents = $repositoryService->getParentRepositories($repo);

            $this->line('Pending ci/cd executions:');

            foreach ($parents as $parent => $versions) {
                $this->line(' - ' . $parent . ' ' . implode(', ', $versions));
            }
        } catch(RepositoryNotOwnedError $error) {
            $this->line('Repository ' . $repo . ' is not owned by the company');
        } catch(\Exception $exception) {
            $this->line('Error getting repository parents');
            $this->line($exception->getMessage());
        }
    }
}
