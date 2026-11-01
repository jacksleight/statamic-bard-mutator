<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Plugins\Plugin;

uses(Tests\TestCase::class);

class MyPlugin extends Plugin
{
    protected array $types = ['paragraph'];

    public function render(array $value, object $info, array $params): ?array
    {
        $value[1]['class'] = 'paragraph';

        return $value;
    }
}

it('executes class based plugin', function () {
    Mutator::plugin(MyPlugin::class);
    $value = $this->getTestValue([[
        'type' => 'paragraph',
        'content' => [[
            'type' => 'text',
            'text' => 'Test',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toContain('<p class="paragraph">Test</p>');
});

class HandlePropertyPlugin extends Plugin
{
    protected ?string $handle = 'from_property';
}

it('uses the default handle', function () {
    expect((new MyPlugin)->handle())->toEqual('my_plugin');
});

it('uses a handle set by property', function () {
    expect((new HandlePropertyPlugin)->handle())->toEqual('from_property');
});

it('uses a handle set by setter', function () {
    expect((new MyPlugin)->handle('from_setter')->handle())->toEqual('from_setter');
});
