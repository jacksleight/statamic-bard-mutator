---
id: fccd9772-d50f-482c-99d5-cf1152b98072
blueprint: html_recipes
title: 'HTML Recipes'
summary: 'Every HTML plugin recipe from docs/examples.md, with str_slug swapped for Str::slug and the missing imports added. The paragraph around images recipe has its own handle and field, because chaining it after the list item paragraph recipe crashes.'
plugin: Tests/html-recipes
template: tests/html-recipes
images:
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::sample.jpg'
          alt: 'Sample image'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'A paragraph that keeps its tags.'
content:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'Getting around Brighton'
  -
    type: heading
    attrs:
      level: 3
    content:
      -
        type: text
        text: 'By bus'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Visit '
      -
        type: text
        text: Statamic
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
      -
        type: text
        text: ', the '
      -
        type: text
        text: 'info test'
        marks:
          -
            type: link
            attrs:
              href: /tests/info
      -
        type: text
        text: ' or '
      -
        type: text
        text: 'email us'
        marks:
          -
            type: link
            attrs:
              href: 'mailto:hi@example.com'
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
                text: 'Bullet item one'
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Bullet item two'
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
                text: 'Ordered item one'
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'Ordered item two'
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
