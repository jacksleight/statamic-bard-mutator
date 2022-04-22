---
title: Examples
nav_order: 5
---

# Examples
{:.no_toc}

<details open markdown="block">
  <summary>
      Table of contents
  </summary>
  {: .text-delta }
* TOC
{:toc}
</details>

---

## Tag Mutators

### Add a class to all bullet lists:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('bullet_list', function ($tag) {
    $tag[0]['attrs']['class'] = 'list';
    return $tag;
});
```

### Add `noopener` to all external links:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::tag('link', function ($tag) {
    if (URL::isExternal($tag[0]['attrs']['href'])) {
        $tag[0]['attrs']['rel'] = 'noopener';
    }
    return $tag;
});
```

### Add an auto-generated ID to all level 2 headings:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('heading', function ($tag, $data) {
    if ($data->attrs->level === 2) {
        $tag[0]['attrs']['id'] = str_slug(collect($data->content)->implode('text', ''));
    }
    return $tag;
});
```

### Add a wrapper div around all tables:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('table', function ($tag) {
    array_unshift($tag, [
        'tag' => 'div',
        'attrs' => ['class' => 'table-wrapper'],
    ]);
    return $tag;
});
```

### Add a wrapper span around all list item content:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('list_item', function ($tag) {
    array_push($tag, 'span');
    return $tag;
});
```

### Convert all images to a custom element:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('image', function ($tag) {
    $tag[0]['tag'] = 'fancy-image';
    return $tag;
});
```