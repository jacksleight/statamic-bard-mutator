<?php

namespace JackSleight\BardMutator\Facades;

use Illuminate\Support\Facades\Facade;

class Mutator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\BardMutator\Mutator::class;
    }
}