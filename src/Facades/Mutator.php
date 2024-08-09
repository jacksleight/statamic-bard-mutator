<?php

namespace JackSleight\StatamicBardMutator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \JackSleight\StatamicBardMutator\Plugins\Plugin plugin(string|\JackSleight\StatamicBardMutator\Plugins\Plugin $plugin)
 * @method static \JackSleight\StatamicBardMutator\Plugins\ClosurePlugin data(array|string $types, \Closure $process)
 * @method static \JackSleight\StatamicBardMutator\Plugins\ClosurePlugin html(array|string $types, ?\Closure $render = null, ?\Closure $parse = null)
 *
 * @see \JackSleight\StatamicBardMutator\Mutator
 */
class Mutator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\StatamicBardMutator\Mutator::class;
    }
}
