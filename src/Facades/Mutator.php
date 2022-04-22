<?php

namespace JackSleight\StatamicBardMutator\Facades;

use Illuminate\Support\Facades\Facade;

class Mutator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\StatamicBardMutator\Mutator::class;
    }
}
