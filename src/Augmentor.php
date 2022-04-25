<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Fieldtypes\Bard\Augmentor as StatamicAugmentor;

class Augmentor extends StatamicAugmentor
{
    public static function augmentValue(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new static($value->fieldtype()))->augment($value->raw());
    }

    public function convertToHtml($value)
    {
        return parent::convertToHtml(Mutator::injectRoot($value));
    }
}
