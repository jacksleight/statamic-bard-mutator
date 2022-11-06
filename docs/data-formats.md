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

## HTML Values

When rendering HTML Tiptap creates HTML values from the node and mark data. These HTML values represent HTML tags and are used to generate the final HTML string. HTML values look like this:

```php
['a', ['href' => 'http://...'], 0]
```

An HTML value is an array with two or three items:

* **0 (string):** The name of the tag
* **1 (array):** An array of tag attributes
* **2 (int\|array, optional):** The content of the tag, can either be:
    * A zero, representing the node content
    * Another nested HTML value