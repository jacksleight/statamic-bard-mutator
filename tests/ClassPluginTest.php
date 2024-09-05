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
