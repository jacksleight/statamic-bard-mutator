<?php

use App\Mutator\Plugins\ClassTest;
use App\Mutator\Plugins\HandleProperty;
use App\Mutator\Plugins\HandleSetter;
use App\Mutator\Plugins\OptionsTest;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::plugin(ClassTest::class);

Mutator::plugin(HandleProperty::class);

Mutator::plugin(HandleSetter::class)->scoped(true)->handle('from_setter');

Mutator::plugin(OptionsTest::class)->options(['label' => 'set with options()']);
