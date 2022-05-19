---
title: Upgrade to 2.0
nav_order: 9
---

# Upgrade to 2.0

Bard Mutator 2.0 integrates with the new TipTap PHP library in Statamic 3.4, which works differently from the previous ProseMirror library. As Bard Mutator provides low-level access to the TipTap/ProseMirror rendering process it also works differently now.

High impact breaking changes have been kept to a minimum, but a core feature has been deprecated and replaced with a new version.

## Breaking

### High Impact

The only high impact breaking change is the node and mark names, some of which have changed in TipTap 2. The table below lists the affected names, which you’ll need to update if you’re using them:

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

### Low Impact

The previously deprecated `Mutator:node()` and `Mutator:mark()` methods have been removed. You can use `Mutator:tag()` instead, but see the notes below.

## Deprecated

Tag rendering isn’t the same in TipTap PHP. Bard Mutator 2.0 includes a compatibility layer that maintains support for tag mutators, but these are deprecated and may be removed in a future version. 

HTML mutators replace tag mutators. They work in a similar way but the data format is different. Below is an example of a tag mutator converted to an HTML mutator. Refer to the HTML mutators, HTML data format, and updated examples for more information. 

```php
Mutator::tag('heading', function ($tag) {
    $tag[0]['attrs']['class'] = 'heading';
    return $tag;
});
```

```php
Mutator::html('heading', function ($html) {
    $html[1]['class'] = 'heading';
    return $html;
});
```