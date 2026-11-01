---
id: 9fb0c0fb-1e16-448a-94dc-5afa5fa4ba3c
blueprint: modifiers
title: Modifiers
summary: 'bard_items, bard_text and bard_html against a field with a scoped heading ID plugin. The modifiers build their own Bard fieldtype with no field, so scoped plugins never run in them, while global plugins do.'
plugin: Tests/modifiers
template: tests/modifiers
content:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'The Lanes'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Narrow alleys and small shops.'
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'North Laine'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Independent cafes and market stalls.'
  -
    type: horizontalRule
---
