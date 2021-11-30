<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.1.14+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-bard-mutator)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-bard-mutator)

# Bard Mutator 

<!-- /statamic:hide -->

This Statamic addon allows you to modify the tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely.

## Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/statamic-bard-mutator
```

## Examples

First of all let's see what this can do with some examples!

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

## Creating Mutators

You should add mutators in your service provider's `boot()` method. They will receive two arguments:

* **tag (array):** The standard [tag value](#tag-values)
* **data (object):** The raw node or mark data

You should return a [tag value](#tag-values).

You can add multiple mutators for the same node or mark, they'll be executed in the order they were added.

## How it Works

### Rendering Process

This is roughly how ProseMirror (the magic behind Bard's content format and rendering) handles the rendering process:

1. The raw content is stored as a ProseMirror document in your entries, these documents consist of nodes and marks
2. ProseMirror converts the raw node and mark data to their standard [tag values](#tag-values)
3. **Bard Mutator jumps in here, allowing you to modify the tag values**
4. ProseMirror renders the tag values to an HTML string

### Tag Values

In its fully expanded format a tag value looks like this:

```php
[
    [
        'tag' => 'a',
        'attrs' => [
            'href' => 'http://...'
        ]
    ]
]
```

A fully expanded tag value is an array of items where each item is an associative array with two keys:

* **tag (string):** The name of the tag
* **attrs (array):** A name/value array of attributes

An array with multiple items will render nested tags, with the content placed within the innermost (last) tag.

If there are no attributes the item can just be the tag name:

```php
[
    ['p']
]
```

And if there's only one item with no attributes the entire tag value can just be the tag name:

```php
'p'
```

The built-in node and mark classes return a mixture of these formats, but for ease and consistency Bard Mutator normalizes them to the fully expanded format before passing to your mutators. You can return any format you like.

**Important:** A tag value that's a single associative array is *not* supported:

```php
// Don't do this, it won't work! Wrap it in another array.
return [
    'tag' => 'a',
    'attrs' => [
        'href' => 'http://...'
    ]
];
```

## Avaliable Nodes & Marks

Bard Mutator will replace all of the built-in node and mark classes with extended versions that support mutation, except for Statamic's Set node. These are:

* **Nodes**
    * blockquote
    * bullet_list
    * code_block
    * hard_break
    * heading
    * horizontal_rule
    * image
    * list_item
    * ordered_list
    * paragraph
    * table
    * table_cell
    * table_header
    * table_row
* **Marks**
    * bold
    * code
    * italic
    * link
    * subscript
    * underline
    * strike
    * superscript

## Compatibility

Because of the way ProseMirror and TipTap work Bard Mutator has to replace the built-in classes/extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace the classes/extensions that are actually being mutated, everyting else is left alone.

*However*, if you have other addons (or user code) that replace any of the classes/extensions that Bard Mutator is also replacing it probably won't work properly. Unfortunately I don’t think there’s a way around that. This does not affect custom nodes and marks.

My other Bard addons use Bard Mutator under the hood, so those are fully compatible. In fact the main reason I developed this in the first place was so multiple addons could make modifications to the built-in classes/extensions at the same time.