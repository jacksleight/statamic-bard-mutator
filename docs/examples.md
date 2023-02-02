---
title: Examples
order: 5
---

# Examples

[TOC]

---

## HTML Mutators

### Add a class to all lists

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['bulletList', 'orderedList'], function ($value) {
    $value[1]['class'] = 'list';
    return $value;
});
```

### Add a class to all external links

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::html('link', function ($value) {
    if (URL::isExternal($value[1]['href'])) {
        $value[1]['class'] = 'external';
    }
    return $value;
});
```

### Add an auto-generated ID to all level 2 headings

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value, $data) {
    if ($data->attrs->level === 2) {
        $value[1]['id'] = str_slug(collect($data->content)->implode('text', ''));
    }
    return $value;
});
```

### Add a wrapper div around all tables

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('table', function ($value) {
    $value = ['div', ['class' => 'table-wrapper'], $value];
    return $value;
});
```

### Add a wrapper span around all bullet list item content

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('listItem', function ($value, $meta) {
    if ($meta['parent']->type === 'bulletList') {
        $value[2] = ['span', [], 0];
    }
    return $value;
});
```

### Convert all images to a custom element

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('image', function ($value) {
    $value[0] = 'fancy-image';
    return $value;
});
```

## Data Mutators

### Remove paragraph tags inside list items

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('listItem', function ($value) {
    if (($value->content[0]->type ?? null) === 'paragraph') {
        $value->content = $value->content[0]->content;
    }
});
```