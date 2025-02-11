---
title: Introduction
order: 1
---

# Introduction

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## How It Works

This is how Tiptap (the magic behind Bard's content format and rendering) handles the rendering process, and how Bard Mutator interacts with that process:

1. The raw content is stored as a ProseMirror document in your entries, these documents consist of [nodes and marks](data-formats)
2. Statamic's augmentation process passes this data to the Tiptap renderer
3. **Bard Mutator's [data plugins](plugins#data-plugins) jump in here, allowing you to modify the raw data**
4. Tiptap converts the raw node and mark data to their standard [tag values](data-formats#html-values)
5. **Bard Mutator's [HTML plugins](plugins#html-plugins) jump in here, allowing you to modify the tag values**
6. Tiptap renders the tag values to an HTML string

## Compatibility

:::warning
Bard's "Save as HTML" option is not recommended when using Mutator. It's not completely unsupported, but only some kinds of mutations will work with it enabled as the changes could cause issues when converting the HTML back to ProseMirror for editing.
:::

In order to give you access to the Tiptap rendering process Bard Mutator has to override the Tiptap editor class and replace the built-in extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace extensions that are actually being mutated, and this is only required for HTML plugins.
