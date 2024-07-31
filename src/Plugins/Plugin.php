<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use ReflectionClass;
use Statamic\Support\Str;

class Plugin
{
    protected ?string $handle = null;

    protected ?string $display = null;

    protected bool $global = false;

    protected array $types = [];

    protected array $options = [];

    public function types(): array
    {
        return $this->types;
    }

    public function handle(string $handle = null): static|string|null
    {
        if (func_num_args()) {
            $this->handle = $handle;

            return $this;
        }

        return $handle ?: Str::snake((new ReflectionClass(static::class))->getShortName());
    }

    public function display(string $display = null): static|string|null
    {
        if (func_num_args()) {
            $this->display = $display;

            return $this;
        }

        return $this->display ?: Str::headline($this->handle());
    }

    public function global(bool $global = null): static|bool
    {
        if (func_num_args()) {
            $this->global = $global;

            return $this;
        }

        return $this->global;
    }

    public function options(array $options = null): static|array
    {
        if (func_get_args()) {
            $this->options = $options;

            return $this;
        }

        return $this->options;
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
