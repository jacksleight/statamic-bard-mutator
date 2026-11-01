---
id: ae80eacf-0830-41e0-925a-54edf63b174f
blueprint: marks
title: Marks
summary: 'Adjacent, combined and overlapping marks, with bold replaced by a nested HTML value so the open and close phases have to match.'
plugin: Tests/marks
template: tests/marks
content:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Plain '
      -
        type: text
        text: bold
        marks:
          -
            type: bold
      -
        type: text
        text: ' plain'
  -
    type: paragraph
    content:
      -
        type: text
        text: one
        marks:
          -
            type: bold
      -
        type: text
        text: two
        marks:
          -
            type: bold
          -
            type: italic
      -
        type: text
        text: three
        marks:
          -
            type: italic
  -
    type: paragraph
    content:
      -
        type: text
        text: 'bold link'
        marks:
          -
            type: bold
          -
            type: link
            attrs:
              href: 'https://statamic.com'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'link start '
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
      -
        type: text
        text: 'bold middle'
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
          -
            type: bold
      -
        type: text
        text: ' link end'
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
  -
    type: paragraph
    content:
      -
        type: text
        text: code
        marks:
          -
            type: code
      -
        type: text
        text: ' then '
      -
        type: text
        text: 'bold code'
        marks:
          -
            type: bold
          -
            type: code
---
