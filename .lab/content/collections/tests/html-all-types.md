---
id: bf04e7a6-d8fe-4d34-8533-787bccd1810f
blueprint: html_all_types
title: 'HTML All Types'
summary: 'A data-bmu attribute added to every node and mark type that HTML plugins support, on content holding all of them. The field is listable, so the CP listing exercises the pre-process-index hook.'
plugin: Tests/html-all-types
template: tests/html-all-types
content:
  -
    type: heading
    attrs:
      level: 1
    content:
      -
        type: text
        text: 'Heading one'
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'Heading two'
  -
    type: heading
    attrs:
      level: 3
    content:
      -
        type: text
        text: 'Heading three'
  -
    type: paragraph
    content:
      -
        type: text
        text: Bold
        marks:
          -
            type: bold
      -
        type: text
        text: ' '
      -
        type: text
        text: italic
        marks:
          -
            type: italic
      -
        type: text
        text: ' '
      -
        type: text
        text: underline
        marks:
          -
            type: underline
      -
        type: text
        text: ' '
      -
        type: text
        text: strike
        marks:
          -
            type: strike
      -
        type: text
        text: ' '
      -
        type: text
        text: small
        marks:
          -
            type: small
      -
        type: text
        text: ' x'
      -
        type: text
        text: super
        marks:
          -
            type: superscript
      -
        type: text
        text: ' x'
      -
        type: text
        text: sub
        marks:
          -
            type: subscript
      -
        type: text
        text: ' '
      -
        type: text
        text: code
        marks:
          -
            type: code
      -
        type: text
        text: ' '
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
        text: 'After a hard break'
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
                text: 'Bullet one'
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Bullet two'
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
                text: 'Ordered one'
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Ordered two'
  -
    type: blockquote
    content:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'A blockquote'
  -
    type: codeBlock
    attrs:
      language: php
    content:
      -
        type: text
        text: "echo 'code block';"
  -
    type: horizontalRule
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::sample.jpg'
          alt: 'Sample image'
  -
    type: table
    content:
      -
        type: tableRow
        content:
          -
            type: tableHeader
            attrs:
              colspan: 1
              rowspan: 1
              colwidth: null
            content:
              -
                type: paragraph
                content:
                  -
                    type: text
                    text: Pier
          -
            type: tableHeader
            attrs:
              colspan: 1
              rowspan: 1
              colwidth: null
            content:
              -
                type: paragraph
                content:
                  -
                    type: text
                    text: Opened
      -
        type: tableRow
        content:
          -
            type: tableCell
            attrs:
              colspan: 1
              rowspan: 1
              colwidth: null
            content:
              -
                type: paragraph
                content:
                  -
                    type: text
                    text: 'Palace Pier'
          -
            type: tableCell
            attrs:
              colspan: 1
              rowspan: 1
              colwidth: null
            content:
              -
                type: paragraph
                content:
                  -
                    type: text
                    text: '1899'
---
