<?php

use App\Mutator\Plugins\Demos\ExternalLinks;
use App\Mutator\Plugins\Demos\HeadingAnchors;
use App\Mutator\Plugins\Demos\LazyImages;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::plugin(ExternalLinks::class);

Mutator::plugin(HeadingAnchors::class);

Mutator::plugin(LazyImages::class);
