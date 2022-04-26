---
title: Rendering
nav_order: 3
---

# Rendering
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

All tag mutators will be applied whenever any Bard field is output, you don’t need to make any changes to your templates. However, only basic functionality is available with this method.

To use advanced features such as [metadata](mutators.html#metadata) and [root mutators](mutators.html#root-mutators) you need to use Bard Mutator's custom rendering, either via the Antlers `bmu` tag or directly.

## Antlers Tag

To use the `bmu` tag update your template from this:

```html
{% raw %}{{ my_content }}{% endraw %}
```

To this:

```html
{% raw %}{{ bmu:my_content }}{% endraw %}
```

## REST API

If you're using Statamic's REST API you can use a [custom resource](https://statamic.dev/rest-api#customizing-resources) and call the render method directly:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

class CustomEntryResource extends EntryResource
{
    public function toArray($request)
    {
        return [
            'my_content' => Mutator::render($this->resource->augmentedValue('my_content')),
        ] + parent::toArray($request);
    }
}
```

## GraphQL API

If you're using Statamic's GraphQL API you can add a [custom field](https://statamic.dev/graphql#custom-fields) and call the render method directly:

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\GraphQL;

GraphQL::addField('Entry_Pages_Pages', 'my_content', function () {
    return [
        'type' => GraphQL::string(),
        'resolve' => function ($entry) {
            return Mutator::render($entry->augmentedValue('my_content'));
        },
    ];
});
```