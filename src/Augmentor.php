<?php

namespace JackSleight\StatamicBardMutator;

use Statamic\Fieldtypes\Bard\Augmentor as StatamicAugmentor;

class Augmentor extends StatamicAugmentor
{
    public function convertToHtml($value)
    {
        return parent::convertToHtml([[
            'type' => 'bmu_root',
            'content' => $value,
        ]]);
    }
}
