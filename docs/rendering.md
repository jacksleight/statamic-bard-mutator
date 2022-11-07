---
title: Rendering
order: 4
---

# Rendering

[TOC]

---

All tag mutators will be applied whenever any Bard field is output, you don’t need to make any changes to your templates. However, only basic functionality is available with this method.

To use advanced features such as [metadata](mutators#metadata) and [data mutators](mutators#data-mutators) you need to use Bard Mutator's render method, either via the `bmu` tag or directly.

## Tag

To use the `bmu` tag update your template as follows:

```html
{{ bmu:my_content }}
```

Looping over sets is also supported:

```html
{{ bmu:my_content }}
    {{ if type == "text" }}
        {{ text }}
    {{ elseif type == "image" }}
        <img src="{{ src }}">
    {{ /if }}
{{ /bmu:my_content }}
```

## Direct

If you need to use Bard Mutator's render method outside of a template, for example when using the REST or GraphQL API's, you can call it directly:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

$my_content = Mutator::render($entity->augmentedValue('my_content'));
```