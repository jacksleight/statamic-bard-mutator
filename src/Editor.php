<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Tiptap\Editor as TiptapEditor;

class Editor extends TiptapEditor
{
    public function setContent($value): self
    {
        if ($this->getContentType($value) === 'Array') {
            $value = Mutator::injectRoot($value);
        }
        return parent::setContent($value);
    }
}
