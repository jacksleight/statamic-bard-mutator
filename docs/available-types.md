---
title: Available Types
order: 7
---

# Available Types

Mutators support mutating the following node and mark types.

## Nodes

| Type                  | Tag Mutators | Data Mutators | Notes |
| --------------------- | :----------: | :-----------: | ----- |
| blockquote            | ●            | ●             |       |
| bullet_list           | ●            | ●             |       |
| code_block            | ●            | ●             |       |
| hard_break            | ●            | ●             |       |
| heading               | ●            | ●             |       |
| horizontal_rule       | ●            | ●             |       |
| image                 | ●            | ●             |       |
| list_item             | ●            | ●             |       |
| ordered_list          | ●            | ●             |       |
| paragraph             | ●            | ●             |       |
| table                 | ●            | ●             |       |
| table_cell            | ●            | ●             |       |
| table_header          | ●            | ●             |       |
| table_row             | ●            | ●             |       |
| set                   |              | ●             |       |
| bmu_root              |              | ●             | Internal node that wraps all content |

## Marks

| Type                  | Tag Mutators | Data Mutators | Notes |
| --------------------- | :----------: | :-----------: | ----- |
| bold                  | ●            | ●             |       |
| code                  | ●            | ●             |       |
| italic                | ●            | ●             |       |
| link                  | ●            | ●             |       |
| small                 | ●            | ●             | Statamic 3.3.9+ |
| strike                | ●            | ●             |       |
| subscript             | ●            | ●             |       |
| superscript           | ●            | ●             |       |
| underline             | ●            | ●             |       |
| bts_span              | ●            | ●             | Part of [Bard Texstyle](https://github.com/jacksleight/statamic-bard-texstyle) |