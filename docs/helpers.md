---
title: Helpers
order: 6
---

# Helpers

[TOC]

---

## Data Helpers

Data helpers are available in the `JackSleight\StatamicBardMutator\Support\Data` namespace.

#### `Data::node($type, $attrs = [], $content = [], $marks = [])`

Creates a new node object.

#### `Data::mark($type, $attrs = [])`

Creates a new mark object.

#### `Data::text($text, $marks = [])`

Creates a new text node object.

#### `Data::html($html|$tag, $attrs = [], $content = [], $marks = [])`

Creates a new HTML node object.

#### `Data::apply($item, ...$properties)`

Apply new properties to an existing node/mark.

#### `Data::clone($item, ...$properties)`

Clone an existing node/mark and optionally apply new properties to it.

#### `Data::morph($item, $into)`

Morph an existing node/mark into a different node/mark.