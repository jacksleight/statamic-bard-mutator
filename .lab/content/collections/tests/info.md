---
id: b7ba461d-7306-4c65-a96b-56226687f509
blueprint: info
title: Info
summary: 'Info object properties written as data attributes: index, depth, parent, prev, next, root and the Bard field handle.'
plugin: Tests/info
template: tests/info
content:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'Info objects'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Plain, '
      -
        type: text
        text: bold
        marks:
          -
            type: bold
      -
        type: text
        text: ' and '
      -
        type: text
        text: italic
        marks:
          -
            type: italic
          -
            type: bold
      -
        type: text
        text: .
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
                text: 'First '
              -
                type: text
                text: item
                marks:
                  -
                    type: bold
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Second item'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Last paragraph'
---
