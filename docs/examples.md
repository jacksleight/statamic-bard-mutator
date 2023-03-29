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

Check out the modifier [example below](examples#using-with-the-bard-modifiers) to see how you could use these in a table of contents.

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

### Remove paragraph tags inside list items

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('paragraph', function ($value, $meta) {
    if (($meta['parent']->type ?? null) === 'listItem') {
        return null;
    }
    return $value;
});
```

### Remove paragraph tags around images

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('paragraph', function ($value, $data) {
    if (($data->content[0]->type ?? null) === 'image') {
        return null;
    }
    return $value;
});
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

Check out the modifier [example below](examples#using-with-the-bard-modifiers) to see how you could use these in a table of contents.

## Using with the Bard modifiers

Statamic includes a set of [modifiers](https://statamic.dev/modifiers) that can extract items from Bard fields and output their content. For example, after adding heading IDs or permalinks you could create a simple table contents like this:

```html
{{ headings = article | raw | bard_items | where('type', 'heading') }}
{{ headings }}
    <a href="#{{ content | bard_text | slugify }}">{{ content | bard_html }}</a>
{{ /headings }}
```