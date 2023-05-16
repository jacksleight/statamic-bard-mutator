<?php

namespace JackSleight\StatamicBardMutator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void data($types, $mutator, $config = [])
 * @method static void html($types, $renderHtml, $parseHtml = null, $config = [])
 * @method static void parseHtml($types, $mutator, $config = [])
 * @method static void renderHtml($types, $mutator, $config = [])
 * @method static void tag($types, $mutator)
 */
class Mutator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JackSleight\StatamicBardMutator\Mutator::class;
    }
}
