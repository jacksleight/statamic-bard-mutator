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
    $inner = array_splice($value, 2, count($value), [0]);
    $value = ['div', ['class' => 'table-wrapper'], $value, ...$inner];
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

### Render all images with a custom view partial

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('image', function ($value) {
    return ['content' => view('partials/image', $value[1])];
});
```
```html
<picture>
    <source srcset="{{ glide:src width="500" format="webp" }}" type="image/webp">
    <img src="{{ glide:src width="500" }}" alt="{{ alt }}">
</picture>
```

## Data Mutators

### Add permalink anchors to all headings

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('heading', function ($data) {
    $slug = str_slug(collect($data->content)->implode('text', ''));
    array_unshift(
        $data->content,
        Data::html('<a id="'.$slug.'" href="#'.$slug.'">#</a>')
    );
});
```

### Remove paragraph tags inside list items

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('listItem', function ($data) {
    if (($data->content[0]->type ?? null) === 'paragraph') {
        $data->content = $data->content[0]->content;
    }
});
```