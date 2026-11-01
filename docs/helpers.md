---
title: Helpers
order: 6
---

# Helpers

[TOC]

---

## Data Helpers

Data helpers are available in the `JackSleight\StatamicBardMutator\Support\Data` class.

#### `Data::node($type, $attrs = [], $content = [], $marks = [])`

Creates a new node object.

#### `Data::mark($type, $attrs = [])`

Creates a new mark object.

#### `Data::text($text, $marks = [])`

Creates a new text node object.

#### `Data::html($tag, $attrs = [], $content = [], $marks = [])`

Creates a new HTML node object that renders a tag around its content.

#### `Data::html($html, $marks = [])`

Creates a new HTML node object from a string of raw HTML. Input is treated as raw HTML, so any text should be escaped with the `e()` helper.

#### `Data::apply($item, ...$properties)`

Apply new properties to an existing node/mark.

#### `Data::clone($item, ...$properties)`

Clone an existing node/mark and optionally apply new properties to it.

#### `Data::morph($item, $into)`

Morph an existing node/mark into a different node/mark.