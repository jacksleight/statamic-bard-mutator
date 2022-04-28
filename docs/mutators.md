---
title: Mutators
nav_order: 3
---

# Mutators
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

Tag mutators allow you to modify the [tag values](data-formats.html#tag-values) that ProseMirror converts to HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. Here's one example, there are more on the [examples](examples.html) page.

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('bullet_list', function ($tag) {
    $tag[0]['attrs']['class'] = 'list';
    return $tag;
});
```

You should add tag mutators in a service provider's `boot()` method. They will receive two or three arguments depending on how you're using Bard Mutator:

* **tag (array):** The standard [tag value](data-formats.html)
* **data (object):** The raw [node and mark data](data-formats.html)
* **meta (array, optional):** Metadata about the current node or mark (see below)

You should return a [tag value](data-formats.html). If you return `null` or an empty array no tags will be rendered but the content will be. You can add multiple tag mutators for the same type, they'll be executed in the order they were added.

---

## Data Mutators

Data mutators allow you to make changes to the raw [node and mark data](data-formats.html) before rendering. They're only available when using Bard Mutator's [render method](rendering.html).

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('paragraph', function ($data, $meta) {
    // ...
});
```

You should add data mutators in a service provider's `boot()` method. They will receive two arguments:

* **data (object):** The raw [node and mark data](data-formats.html)
* **meta (array):** Metadata about the current node or mark (see below)

Data mutators do not return a value, you can just modify the objects directly. You can add multiple data mutators for the same type, they'll be executed in the order they were added.

---

## Metadata

The `$meta` argument contains metadata about the current node or mark. It's only avalibale when using Bard Mutator's [render method](rendering.html). It's an array that contains the following keys:

* **parent (object):** The parent node
* **prev (object):** The previous node/mark
* **next (object):** The next node/mark
* **index (int):** The index of the current node/mark
* **depth (int):** The depth of the current node/mark