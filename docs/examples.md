---
title: Examples
order: 5
---

# Examples

[TOC]

---

## HTML Plugins

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
use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::html('link', function ($value) {
    if (Str::startsWith($value[1]['href'], ['http://', 'https://', '//']) && URL::isExternal($value[1]['href'])) {
        $value[1]['class'] = 'external';
    }
    return $value;
});
```

### Add an auto-generated ID to all level 2 headings

```php
use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value, $item) {
    if ($item->attrs->level === 2) {
        $value[1]['id'] = Str::slug(collect($item->content ?? [])->implode('text', ''));
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

Mutator::html('listItem', function ($value, $info) {
    if ($info->parent->type === 'bulletList') {
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

Mutator::html('paragraph', function ($value, $info) {
    if (($info->parent->type ?? null) === 'listItem') {
        return null;
    }
    return $value;
});
```

### Remove paragraph tags around images

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('paragraph', function ($value, $item) {
    if (($item->content[0]->type ?? null) === 'image') {
        return null;
    }
    return $value;
});
```

### Wrap all heading text with permalink anchors and add a class

```php
use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value, $item) {
    $slug = Str::slug(collect($item->content)->implode('text', ''));
    $value[2] = ['a', [
        'id' => $slug,
        'href' => '#'.$slug,
        'class' => 'hover:underline',
    ], 0];
    return $value;
});
```

---

## Data Plugins

### Add permalink anchors before all heading text

```php
use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('heading', function ($item) {
    $slug = Str::slug(collect($item->content)->implode('text', ''));
    array_unshift(
        $item->content,
        Data::html('<a id="'.$slug.'" href="#'.$slug.'">#</a>')
    );
});
```

### Convert blockquotes to figures with figcaptions

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('blockquote', function ($item) {
    Data::morph($item, Data::html('figure', ['class' => 'quote'], [
        Data::clone($item, content: collect($item->content)->slice(0, -1)->values()->all()),
        Data::html('figcaption', [], [collect($item->content)->last()]),
    ]));
});
```

### Add SVG icons to links

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('link', function ($info) {
    $node = $info->parent->item;
    Data::morph($node, Data::html('<svg></svg> '.e($node->text), $node->marks));
});
```

### Obfuscate email address links

```php
use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Statamic;

Mutator::data('link', function ($item, $info) {
    if (! Str::startsWith($item->attrs->href, 'mailto:')) {
        return;
    }
    $node = $info->parent->item;
    $href = Statamic::modify($item->attrs->href)->obfuscateEmail();
    $marks = collect($node->marks)->reject(fn ($mark) => $mark === $item)->values()->all();
    Data::morph($node, Data::html('<a href="'.$href.'">'.e($node->text).'</a>', $marks));
});
```

Check out the modifier [example below](examples#using-with-the-bard-modifiers) to see how you could use these in a table of contents.

---

## Using with the Bard modifiers

Statamic includes a set of [modifiers](https://statamic.dev/modifiers) that can extract items from Bard fields and output their content. For example, after adding heading IDs or permalinks you could create a simple table of contents like this:

```html
{{ headings = article | raw | bard_items | where('type', 'heading') }}
{{ headings }}
    <a href="#{{ content | bard_text | slugify }}">{{ content | bard_html }}</a>
{{ /headings }}
```

The modifiers render without a field, so only global plugins run there, scoped plugins won't.
