<?php

namespace App\Services;

use App\Errors\Repository\RepositoryNotOwnedError;
use Illuminate\Support\Facades\Storage;
use App\Models\Repository;

class RepositoryService {

    /**
     * @var array<string, Repository>
     */
    protected array $repos = [];

    public function __construct()
    {
        $repositoryDirs = Storage::disk('repos')->directories();

        foreach($repositoryDirs as $dirname) {
            $repo = $this->createRepository($dirname);

            $this->repos[$repo->name] = $repo;
        }

        foreach ($this->repos as $repo) {
            $this->fillRelatives($repo);
        }
    }

    protected function createRepository($dirname): Repository
    {
        $composer = json_decode(Storage::disk('repos')->get($dirname . '/composer.json'), true);
        $repo = new Repository($composer);

        return $repo;
    }

    protected function isOwnRepository(string $name): bool
    {
        return isset($this->repos[$name]);
    }

    protected function fillRelatives(Repository $repo): void
    {
        foreach ($repo->getDependencies() as $dependant => $version) {
            if (isset($this->repos[$dependant])) {
                $this->repos[$dependant]->addParent($repo->name, $version);
                $repo->addChild($this->repos[$dependant]);
            }
        }
    }

    protected function getParents(string $repo, $parents = []): array
    {
        $parentRepos = $this->repos[$repo]->getParents();
        $parents[$repo] = [];

        foreach ($parentRepos as $name => $version) {
            $parents[$repo][] = $version;

            if ($this->isOwnRepository($name)) {
                $parents = $this->getParents($name, $parents);
            }
        }

        return $parents;
    }

    public function buildTree(): array
    {
        $tree = [];

        foreach ($this->repos as $repo) {
            if (!$repo->hasParents()) {
                $tree[] = $repo;
            }
        }

        return $tree;
    }

    public function getParentRepositories(string $name): array
    {
        if (!$this->isOwnRepository($name)) {
            throw new RepositoryNotOwnedError();
        }

        return $this->getParents($name);
    }
}
