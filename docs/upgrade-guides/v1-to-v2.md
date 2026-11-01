---
title: Upgrade v1 to v2
order: 1
---

# Upgrade from v1 to v2

[TOC]

---

Bard Mutator 2 integrates with the new `tiptap-php` library in Statamic 3.4, which works differently from the previous version. As Bard Mutator provides low-level access to the Tiptap rendering process it also works differently now. There are two high-impact breaking changes, and a core feature has been deprecated and replaced with a new version.

---

## Breaking Changes

### Tag & render method (High Impact)

The `{{ bmu }}` tag and `Mutator::render()` method have been removed in favour of binding Bard Mutator's Editor class. This allows all advanced features to just work without the need to use a custom tag and within API responses. If you were using these you should bind the new class, remove those calls and just output your Bard values in the usual Statamic way.

:::note
The Editor class binding was itself removed in v3, so if you're upgrading further you can skip it. See [Upgrade v2 to v3](upgrade-guides/v2-to-v3#editor-class-binding-removed-high-impact).
:::

### Node & mark name changes (High Impact)

Some node and mark names have changed in Tiptap 2. The table below lists the affected names, which you’ll need to update if you’re using them:

| Old             | New            |
| --------------- | -------------- |
| bullet_list     | bulletList     | 
| code_block      | codeBlock      | 
| hard_break      | hardBreak      | 
| horizontal_rule | horizontalRule | 
| list_item       | listItem       | 
| ordered_list    | orderedList    | 
| table_cell      | tableCell      | 
| table_header    | tableHeader    | 
| table_row       | tableRow       | 
| bmu_root        | bmuRoot        | 
| bts_span        | btsSpan        | 

### Mutator node and mark methods removed (Low Impact)

The previously deprecated `Mutator::node()` and `Mutator::mark()` methods have been removed. You can use `Mutator::tag()` instead, but see the notes below.

---

## Deprecated

### Tag Mutators

Tag rendering isn’t the same in Tiptap PHP. Bard Mutator 2 includes a compatibility layer that maintains support for tag mutators, but these are deprecated and may be removed in a future version. 

HTML mutators replace tag mutators. They work in a similar way but the data format is different. Below is an example of a tag mutator converted to an HTML mutator.

```php
Mutator::tag('heading', function ($tag) {
    $tag[0]['attrs']['class'] = 'heading';
    return $tag;
});
```

```php
Mutator::html('heading', function ($value) {
    $value[1]['class'] = 'heading';
    return $value;
});
```