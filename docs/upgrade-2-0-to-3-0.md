---
title: Upgrade 2.0 to 3.0
order: 110
---

# Upgrade from 2.0 to 3.0

[TOC]

---

This update includes some fairly significant changes to the terminology and variables used in mutators, and all documentation and examples have been updated to use the new conventions. However none of these changes are breaking, all existing mutators should continue to work exactly as before. 

The terminology changes are:

* Mutators are now known as Plugins
* The `$data` argument is now called `$item`
* The `$meta` argument is now an object called `$info`

All documentation, examples and the rest of this upgrade guide use this new terminology.

## Breaking Changes

### Editor class binding removed (High Impact)

It is no longer necessary to bind a custom Tiptap Editor class in order to use advanced features, and Bard Mutator's Editor class has been removed. If you enabled this you should remove it from your app service providers `register()` method:

```diff
-$this->app->bind(
-    \Tiptap\Editor::class,
-    \JackSleight\StatamicBardMutator\Editor::class
-);
```

### Deprecated methods removed (Low Impact)

## Deprecated

### Metadata argument

The `$meta` argument that contained information about the current node or mark has been superseded by the `$info` argument. This is an object instead of an array.

### Data argument

The `$data` argument that contained the source node or mark object has been superseded by the `$item` argument.

### Individual render/parse HTML methods

The individual `Mutator::renderHtml()` and `Mutator::parseHtml()` methods have been deprecated. These were never documentented so it's unlinkely anyone is using them, and they were just aliases for `Mutator::html()` anyway.

### Reverse HTML mutators

Reverse HTML mutators have been deprecated and will be removed in a future version. They never really made sense as part of Mutator, they can’t work with the new scoped plugins feature, and as far as I’m aware no one’s using using them anyway.