<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Fieldtypes\Bard\Augmentor as StatamicAugmentor;

class Augmentor extends StatamicAugmentor
{
    public function convertToHtml($value)
    {
        return parent::convertToHtml(Mutator::injectRoot($value));
    }
}
