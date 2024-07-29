<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use ReflectionClass;
use Statamic\Support\Str;

class Plugin
{
    protected array $types = [];

    protected string $handle;

    protected array $config = [];

    protected bool $global = false;

    public function types(): array
    {
        return $this->types;
    }

    public function handle(string $handle = null): static|string
    {
        if (func_num_args()) {
            $this->handle = $handle;

            return $this;
        }

        if ($this->handle) {
            return $this->handle;
        }

        return Str::snake((new ReflectionClass(static::class))->getShortName());
    }

    public function global(bool $global = null): static|bool
    {
        if (func_num_args()) {
            $this->global = $global;

            return $this;
        }

        return $this->global;
    }

    public function config(array $config = null): static|array
    {
        if (func_num_args()) {
            $this->config = $config;

            return $this;
        }

        return $this->config;
    }

    public function plugins(): array
    {
        return [];
    }
}
