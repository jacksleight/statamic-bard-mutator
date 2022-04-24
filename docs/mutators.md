---
title: Mutators
nav_order: 4
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

* **tag (array):** The standard [tag value](data-formats.html#tag-values)
* **data (object):** The raw [node](data-formats.html#node-data) and [mark](data-formats.html#mark-data) data
* **meta (array, optional):** Metadata about the current node or mark (see below)

You should return a [tag value](data-formats.html#tag-values). You can add multiple tag mutators for the same node or mark, they'll be executed in the order they were added.

### Metadata

The third `$meta` argument contains contextual metadata about the current node or mark and is only avalibale when using [the Bard Mutator tag](templating.html#the-bard-mutator-tag). It's an array that contains the following keys:

* **parent (object):** The parent node
* **next (object):** The next node/mark
* **prev (object):** The previous node/mark
* **index (object):** The index of the current node/mark

---

## Root Mutators

Root mutators allow you to manipulate the raw [node](data-formats.html#node-data) and [mark](data-formats.html#mark-data) data before anything is rendered to HTML. They're an advanced feature that give you access to the entire ProseMirror document and are only available when using [the Bard Mutator tag](templating.html#the-bard-mutator-tag).

```php
use Closure;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::root(function ($data, Closure $collect) {
    Data::walk($data, function ($item, $meta) {
        // do something complicated
    });
});
```

You should add root mutators in a service provider's `boot()` method. They will one argument:

* **data (object):** The entire ProseMirror document within a special `bmu_root` node that's part of Bard Mutator

A `Data::walk()` helper is also provided that will walk the entire document and call the provided callback for each node/mark.

Root mutators do not return a value, you should just modify the node/mark objects directly. You can add multiple root mutators, they'll be executed in the order they were added.