<?php

namespace App\Models;

class Repository {

    public readonly string $name;
    public readonly array $dependencies;

    protected array $parents;
    protected array $childs;

    public function __construct(array $composer)
    {
        $this->name = $composer['name'];
        $this->dependencies = isset($composer['require']) ? $composer['require'] : [];
        $this->parents = [];
        $this->childs = [];
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function addParent(string $parent, string $version): void
    {
        $this->parents[$parent] = $version;
    }

    public function addChild(Repository $repository): void
    {
        $this->childs[] = $repository;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function getParents(): array
    {
        return $this->parents;
    }

    public function hasParents(): bool
    {
        return !empty($this->parents);
    }
}
