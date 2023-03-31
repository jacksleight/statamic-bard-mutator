<?php

namespace Tests;

use JackSleight\StatamicBardMutator\ServiceProvider;
use JackSleight\StatamicBardMutator\TestServiceProvider;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Fieldtypes\Bard\Augmentor;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class,
            \Statamic\Providers\BardServiceProvider::class,
        ];
    }

    protected function getTestNode($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type' => $type,
            'attrs' => $attrs ? $attrs : null,
        ]]);
    }

    protected function getTestMark($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type' => 'text',
            'marks' => [[
                'type' => $type,
                'attrs' => $attrs ? $attrs : null,
            ]],
        ]]);
    }

    protected function getTestValue($value)
    {
        return new Value($value, 'handle', new Bard());
    }

    protected function renderTestValue(Value $value)
    {
        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }
}
