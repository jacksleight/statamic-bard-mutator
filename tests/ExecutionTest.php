<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class ExecutionTest extends TestCase
{
    /** @test */
    public function it_calls_mutator_once_per_node()
    {
        $calls = 0;
        Mutator::html('paragraph', function ($value) use (&$calls) {
            $calls++;

            return $value;
        });

        $value = $this->getTestValue([[
            'type' => 'paragraph',
        ]]);
        $this->assertEquals('<p></p>', $this->renderTestValue($value));
        $this->assertEquals(1, $calls);
    }

    /** @test */
    public function it_calls_mutator_once_per_mark()
    {
        $calls = 0;
        Mutator::html('bold', function ($value) use (&$calls) {
            $calls++;

            return $value;
        });

        $value = $this->getTestValue([[
            'type' => 'text',
            'text' => 'Some text',
            'marks' => [
                [
                    'type' => 'bold',
                ],
            ],
        ]]);
        $this->assertEquals('<strong>Some text</strong>', $this->renderTestValue($value));
        $this->assertEquals(1, $calls);
    }

    /** @test */
    public function it_calls_mutator_once_per_adjacent_marks()
    {
        $calls = 0;
        Mutator::html('bold', function ($value) use (&$calls) {
            $calls++;

            return $value;
        });

        $value = $this->getTestValue([
            [
                'type' => 'text',
                'text' => 'Some text',
                'marks' => [
                    [
                        'type' => 'bold',
                    ],
                ],
            ],
            [
                'type' => 'text',
                'text' => ' and some more text',
                'marks' => [
                    [
                        'type' => 'bold',
                    ],
                ],
            ],
        ]);
        $this->assertEquals('<strong>Some text and some more text</strong>', $this->renderTestValue($value));
        $this->assertEquals(1, $calls);
    }
}
