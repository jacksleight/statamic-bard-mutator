---
title: Data Formats
order: 6
---

# Data Formats

[TOC]

---

## Node Data

Nodes mostly map to block elements in the rendered HTML. They're used for things like paragraphs, headings and lists. Node data looks like this:

```yaml
-
    type: heading
    attrs:
        level: 1
    content:
        - ...
    marks:
        - ...
    text: ...
```

Each node is an object with the following properties:

* **type (string):** The type of the node
* **attrs (object, optional):** An object of attributes
* **content (array, optional):** An array of child nodes
* **marks (array, optional):** An array of marks that will be applied to this node
* **text (string, optional):** Content of a text node

---

## Mark Data

Marks mostly map to inline elements in the rendered HTML. They're used for things like links, bold, and italic text. Marks are not nested in the same way they are in HTML. Instead they're applied to a node in a flat list. For example, a bold link is a text node with marks that look like this:

```yaml
-
    type: text
    text: 'This is a bold link'
    marks:
        -
            type: bold
        -
            type: link
            attrs:
                href: 'http://example.com/'
```

Each mark is an object with the following properties:

* **type (string):** The type of the mark
* **attrs (object, optional):** An object of attributes

---

## Tag Values

When rendering HTML ProseMirror creates tag values from the node and mark data. These tag values represent HTML tags and are used to generate the final HTML string.

In their fully expanded format a tag value looks like this:

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