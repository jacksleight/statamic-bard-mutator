---
id: ee3cf71b-648e-4eaf-a358-703bed76580b
blueprint: scoped
title: Scoped
summary: 'Two fields with the same content. A scoped plugin is enabled on the first only; an unscoped plugin on horizontal rules runs on both, and on every other page.'
plugin: Tests/scoped
template: tests/scoped
first:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'First paragraph'
  -
    type: horizontalRule
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Second paragraph'
second:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'First paragraph'
  -
    type: horizontalRule
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Second paragraph'
---
