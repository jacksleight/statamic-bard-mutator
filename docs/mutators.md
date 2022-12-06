---
title: Mutators
order: 3
---

# Mutators

[TOC]

---

## Tag Mutators

Tag mutators allow you to modify the [tag values](data-formats#tag-values) that ProseMirror converts to HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. Here's an example that adds a class attribute to all lists, there are more on the [examples](examples) page.

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag(['bullet_list', 'ordered_list'], function ($tag) {
    $tag[0]['attrs']['class'] = 'list';
    return $tag;
});
```

You should add tag mutators in your app service provider's `boot()` method. They will receive two or three arguments depending on how you're using Bard Mutator:

* **tag (array):** The standard [tag value](data-formats)
* **data (object):** The raw [node and mark data](data-formats)
* **meta (array, optional):** Metadata about the current node or mark (see below)

You should return a [tag value](data-formats). If you return `null` or an empty array no tags will be rendered but the content will be. You can add multiple tag mutators for the same type, they'll be executed in the order they were added.

---

## Data Mutators

Data mutators allow you to make changes to the raw [node and mark data](data-formats) before anything is rendered to HTML. They're only available when using Bard Mutator's [render method](rendering):

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::data('heading', function ($data) {
    // modify $data...
});
```

You should add data mutators in your app service provider's `boot()` method. They will receive two arguments:

* **data (object):** The raw [node and mark data](data-formats)
* **meta (array):** Metadata about the current node or mark (see below)

Data mutators do not return a value, you can just modify the objects directly. You can add multiple data mutators for the same type, they'll be executed in the order they were added.

---

## Metadata

The `$meta` argument contains metadata about the current node or mark. It's only available when using Bard Mutator's [render method](rendering). It's an array that contains the following keys:

* **parent (object):** The parent node
* **prev (object):** The previous node/mark
* **next (object):** The next node/mark
* **index (int):** The index of the current node/mark
* **depth (int):** The depth of the current node/mark