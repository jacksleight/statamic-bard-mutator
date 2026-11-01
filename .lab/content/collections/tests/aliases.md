---
id: 5857e733-e469-4210-87e2-63d94a36e1cd
blueprint: aliases
title: Aliases
summary: 'A plugin registered with snake case type aliases: code_block, unordered_list, ordered_list and list_item.'
plugin: Tests/aliases
template: tests/aliases
content:
  -
    type: codeBlock
    attrs:
      language: php
    content:
      -
        type: text
        text: "echo 'aliased';"
  -
    type: bulletList
    content:
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: Bullet
  -
    type: orderedList
    attrs:
      start: 1
    content:
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: Ordered
---
