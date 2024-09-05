<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use ReflectionClass;
use Statamic\Support\Str;

class Plugin
{
    protected ?string $handle = null;

    protected ?string $display = null;

    protected bool $scoped = false;

    protected array $types = [];

    protected array $options = [];

    public function types(): array
    {
        return $this->types;
    }

    public function handle(?string $handle = null): static|string|null
    {
        if (func_num_args()) {
            $this->handle = $handle;

            return $this;
        }

        return $handle ?: Str::snake((new ReflectionClass(static::class))->getShortName());
    }

    public function display(?string $display = null): static|string|null
    {
        if (func_num_args()) {
            $this->display = $display;

            return $this;
        }

        return $this->display ?: Str::headline($this->handle());
    }

    public function scoped(?bool $scoped = null): static|bool
    {
        if (func_num_args()) {
            $this->scoped = $scoped;

            return $this;
        }

        return $this->scoped;
    }

    public function options(?array $options = null): static|array
    {
        if (func_get_args()) {
            $this->options = $options;

            return $this;
        }

        return $this->options;
    }

    public function process(object $item, object $info): void {}

    public function render(array $value, object $info, array $params): ?array
    {
        return $value;
    }

    public function parse(array $value, object $info, array $params): array
    {
        return $value;
    }
}
