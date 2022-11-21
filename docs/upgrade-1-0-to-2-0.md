---
title: Upgrade 1.0 to 2.0
order: 9
---

# Upgrade from 1.0 to 2.0

[TOC]

---

Bard Mutator 2.0 integrates with the new Tiptap 2 PHP library in Statamic 3.4, which works differently from the previous version. As Bard Mutator provides low-level access to the Tiptap rendering process it also works differently now. There are two high-impact breaking changes, and a core feature has been deprecated and replaced with a new version.

## Breaking Changes

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

### Mutator node and mark methods removed (Low Impact)

The previously deprecated `Mutator:node()` and `Mutator:mark()` methods have been removed. You can use `Mutator:tag()` instead, but see the notes below.

## Deprecated

### Tag Mutators

Tag rendering isn’t the same in Tiptap PHP. Bard Mutator 2.0 includes a compatibility layer that maintains support for tag mutators, but these are deprecated and may be removed in a future version. 

HTML mutators replace tag mutators. They work in a similar way but the data format is different. Below is an example of a tag mutator converted to an HTML mutator. Refer to the [HTML mutators](mutators), [HTML value format](data-formats), and updated [examples](examples) for more information. 

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

### Tag & Render Method

The `{{ bmu }}` tag and `Mutator::render()` method are no longer needed and do nothing. Data mutators and metadata are now avaliable whenever any Bard content is rendered. If you were using these you should remove those calls and just output your Bard values in the usual Statamic way.