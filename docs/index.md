---
title: Introduction
order: 1
---

# Introduction

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## How It Works

This is how ProseMirror (the magic behind Bard's content format and rendering) handles the rendering process, and how Bard Mutator interacts with that process:

1. The raw content is stored as a ProseMirror document in your entries, these documents consist of [nodes and marks](data-formats)
2. Statamic's augmentation process passes this data to the ProseMirror renderer
3. **Bard Mutator's [data mutators](mutators#data-mutators) jump in here, allowing you to modify the raw data**
4. ProseMirror converts the raw node and mark data to their standard [tag values](data-formats#tag-values)
5. **Bard Mutator's [tag mutators](mutators#tag-mutators) jump in here, allowing you to modify the tag values**
6. ProseMirror renders the tag values to an HTML string