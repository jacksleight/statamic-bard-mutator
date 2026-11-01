---
id: 71722d75-0c69-4d79-ae32-60cde2ed84d0
blueprint: inline
title: Inline
summary: 'An inline Bard field. The paragraph plugin should never fire because inline content has no paragraph.'
plugin: Tests/inline
template: tests/inline
content:
  -
    type: text
    text: 'Inline '
  -
    type: text
    text: bold
    marks:
      -
        type: bold
  -
    type: text
    text: ' and a '
  -
    type: text
    text: link
    marks:
      -
        type: link
        attrs:
          href: 'https://statamic.com'
  -
    type: hardBreak
  -
    type: text
    text: 'after a break'
---
