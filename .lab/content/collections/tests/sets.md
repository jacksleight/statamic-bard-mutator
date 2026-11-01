---
id: 33ee5dd3-1888-4c98-b14d-01560c8742a9
blueprint: sets
title: Sets
summary: 'A Bard field with sets. A set data plugin changes the set values and inserts a paragraph before each set.'
plugin: Tests/sets
template: tests/sets
content:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Before the first set.'
  -
    type: set
    attrs:
      id: magZwKmF
      enabled: true
      values:
        type: callout
        kind: tip
        text: 'Original tip text'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Between the sets.'
  -
    type: set
    attrs:
      id: WaQNhEkn
      enabled: true
      values:
        type: callout
        kind: warning
        text: 'Original warning text'
---
