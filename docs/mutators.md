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

You should add tag mutators in your service provider's `boot()` method. They will receive two or three arguments depending on how you're using Bard Mutator:

* **tag (array):** The standard [tag value](data-formats.html#tag-values)
* **data (object):** The raw [node](data-formats.html#node-data) and [mark](data-formats.html#mark-data) data
* **meta (object, optional):** Contextual metadata about the current node or mark

You should return a [tag value](data-formats.html#tag-values). You can add multiple mutators for the same node or mark, they'll be executed in the order they were added.

### Contextual Metadata

The third `$meta` argument contains contextual metadata about the current node or mark and is only avalibale when using [the Bard Mutator tag](templating.html#the-bard-mutator-tag). It's an object that contains the following properties:

* **parent (object):** The parent node
* **next (object):** The next node/mark
* **prev (object):** The previous node/mark
* **index (object):** The index of the current node/mark

---

## Root Mutators

Root mutators allow you to manipulate the raw [node](data-formats.html#node-data) and [mark](data-formats.html#mark-data) data before anything is rendered to HTML. They're an advanced feature that give you access to the entire ProseMirror document and are only avalibale when using [the Bard Mutator tag](templating.html#the-bard-mutator-tag).

```php
use Closure;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::root(function (Closure $collect) {
    $collect()
        ->filter(fn ($data) => ...)
        ->each(function ($data) {
            // do something complicated
        });
});
```

You should add root mutators in your service provider's `boot()` method. They are run through Laravel's service provider and can accept any of the following arguments:

* **data (object):** The entire ProseMirror document within a special `bmu_root` node that's part of Bard Mutator
* **collect (closure):** A closure that will return a flat collection of all nodes and marks in the document

Root mutators do not return a value, you should just modify the node/mark objects directly.