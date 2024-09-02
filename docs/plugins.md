---
title: Plugins
order: 3
---

# Plugins

[TOC]

---

## Data Plugins

Data plugins allow you to make changes to the [node and mark objects](formats) before anything is rendered to HTML. These are most useful when you want to add new content or make significant changes to the structure. Here's an example that adds permalink anchors to all headings:

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('heading', function ($item) {
    $slug = str_slug(collect($item->content)->implode('text', ''));
    array_unshift(
        $item->content,
        Data::html('<a id="'.$slug.'" href="#'.$slug.'">#</a>')
    );
});
```

You should add data plugins in a service provider's `boot()` method. They can receive any of the following arguments which you can specify in any order:

* **item (object):** The [node or mark](formats) object
* **info (object):** Information about the current node or mark (see below)
* **type (string):** The type of the current node or mark

Data plugins do not return a value, you can just modify the objects directly. You can add multiple data plugins for the same type, they'll be executed in the order they were added.

---

## HTML Plugins

HTML plugins allow you to modify the [HTML values](formats#html-values) that Tiptap converts to HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. Here's an example that adds a class attribute to all lists, there are more on the [examples](examples) page:

```php
# app/Providers/AppServiceProvider.php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['bulletList', 'orderedList'], function ($value) {
    $value[1]['class'] = 'list';
    return $value;
});
```

You should add render HTML plugins in a service provider's `boot()` method. They can receive any of the following arguments which you can specify in any order:

* **value (array):** The normal [HTML value](formats#html-values)
* **item (object):** The source [node or mark](formats) object
* **info (object):** Information about the current node or mark (see below)
* **type (string):** The type of the current node or mark

You should return an [HTML value](formats#html-values). If you return `null` or an empty array no tags will be rendered but the content will be. You can add multiple tag plugins for the same type, they'll be executed in the order they were added.

---

## Class Based Plugins

In addition to closure based plugins you can add class based plugins, which can be useful when you want to re-use plugins or just keep things more organised. A class based plugin should extend the `Plugin` class, implement a `types` property or method, and implement the `process` and/or `render` methods:

```php
namespace App\MutatorPlugins;

use JackSleight\StatamicBardMutator\Plugins\Plugin;

class MyPlugin extends Plugin
{
    protected array $types = ['heading'];

    public function process(object $item, object $info): void
    {
        // Perform data changes
    }

    public function render(array $value, object $info, array $params): array
    {
        // Perform HTML changes
    }
}
```

To register a class based plugin use the `Mutator::plugin()` method:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::plugin(MyPlugin::class);
```

---

## Scoped Plugins

By default all plugins are global and run on every bard field. You can limit a plugin to specific fields by making it scoped and then enabling it through the Mutator Plugins config option in the blueprint editor. Closure based plugins need to be given a handle before they will appear in the blueprint editor, and you can optionally specify a display value:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::plugin(MyPlugin::class)->scoped(true);

Mutator::html([...], fn () => ...)
    ->scoped(true)
    ->handle('my_closure_plugin')
    ->display('My Closure Plugin');
```

---

## Info Objects

The `$info` argument contains information about the current node or mark. It's an object with the following properties:

* **root (object):** The `bmuRoot` node for this Bard value
* **parent (object):** The parent node
* **prev (object):** The previous node/mark
* **next (object):** The next node/mark
* **index (int):** The index of the current node/mark
* **depth (int):** The depth of the current node/mark
* **bard (object):** The Bard field object