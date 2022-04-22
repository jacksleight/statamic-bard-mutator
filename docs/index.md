---
title: Introduction
nav_order: 1
---

# Introduction

This Statamic addon allows you to modify the tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also manipulate the raw node and mark data before anything is rendered to HTML, if you need to do something complicated.

## How ProseMirror's rendering process works

First of all it might be useful to know how ProseMirror (the magic behind Bard's content format and rendering) handles the rendering process:

1. The raw content is stored as a ProseMirror document in your entries, these documents consist of [nodes](data-formats.html#node-data) and [marks](data-formats.html#mark-data)
2. Statamic's augmentation process passes this data to the ProseMirror renderer
3. **Bard Mutator's [root mutators](mutators.html#root-mutators) jump in here, allowing you to modify the raw data**
4. ProseMirror converts the raw node and mark data to their standard [tag values](data-formats.html#tag-values)
5. **Bard Mutator's [tag mutators](mutators.html#tag-mutators) jump in here, allowing you to modify the tag values**
6. ProseMirror renders the tag values to an HTML string