<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use ReflectionClass;
use Statamic\Support\Str;
use Statamic\Support\Traits\FluentlyGetsAndSets;

class Plugin
{
    use FluentlyGetsAndSets;

    protected string $handle;

    protected bool $global = false;

    protected array $types = [];

    protected array $options = [];

    public function types(): array
    {
        return $this->types;
    }

    public function handle(string $handle = null): static|string
    {
        return $this->fluentlyGetOrSet('handle', $handle)
            ->getter(fn ($handle) => $handle ?: Str::snake((new ReflectionClass(static::class))->getShortName()))
            ->args(func_get_args());
    }

    public function global(bool $global = null): static|bool
    {
        return $this->fluentlyGetOrSet('global', $global)
            ->args(func_get_args());
    }

    public function options(array $options = null): static|array
    {
        return $this->fluentlyGetOrSet('options', $options)
            ->args(func_get_args());
    }

    public function plugins(): array
    {
        return [];
    }

    public function process(object $data, array $meta): void
    {
    }

    public function render(array $value, array $meta, array $params): array
    {
        return $value;
    }

    public function parse(array $value, array $meta, array $params): array
    {
        return $value;
    }
}
