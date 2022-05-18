<?php

namespace Tests;

use JackSleight\StatamicBardMutator\ServiceProvider;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            \Statamic\Providers\BardServiceProvider::class,
        ];
    }

    protected function getTestNode($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type'  => $type,
            'attrs' => $attrs,
        ]]);
    }

    protected function getTestMark($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type'  => 'text',
            'marks' => [[
                'type'  => $type,
                'attrs' => $attrs,
            ]],
        ]]);
    }

    protected function getTestValue($value)
    {
        return new Value($value, 'handle', new Bard());
    }
}
