---
title: Introduction
nav_order: 1
---

# Introduction

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## How It Works

This is how TipTap (the magic behind Bard's content format and rendering) handles the rendering process, and how Bard Mutator interacts with that process:

1. The raw content is stored as a ProseMirror document in your entries, these documents consist of [nodes and marks](data-formats.html)
2. Statamic's augmentation process passes this data to the TipTap renderer
3. **Bard Mutator's [data mutators](mutators.html#data-mutators) jump in here, allowing you to modify the raw data**
4. TipTap converts the raw node and mark data to their standard [tag values](data-formats.html#html-values)
5. **Bard Mutator's [HTML mutators](mutators.html#html-mutators) jump in here, allowing you to modify the tag values**
6. TipTap renders the tag values to an HTML string

## Compatibility

In order to give you access to the TipTap rendering process Bard Mutator has to replace the built-in extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace the extensions that are actually being mutated, everyting else is left alone.

*However*, if you have other addons (or user code) that replace any of the extensions that Bard Mutator is also replacing it probably won't work properly. Unfortunately I don’t think there’s a way around that. This does not affect custom nodes and marks.